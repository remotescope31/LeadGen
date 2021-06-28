<?php

namespace App\Http\Controllers;

use App\City;
use App\Client;
use App\Other;
use App\Phone;
use App\PolicyClient;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Node\SelectorNode;

class RegionController extends Controller
{


    public function search_region(Request $request)
    {


        $term=$request->term;
        $data = Region::where('name','LIKE','%'.$term.'%')
            ->take(1)
            ->get();


        if (count($data) == 0) {
            $data = Region::where('code','LIKE','%'.$term.'%')
                ->take(1)
                ->get();
        }


        $result=array();
        foreach ($data as $key => $v){
            $result[]=['value' =>$v->name];
        }
        //  dd($result);

        return response()->json($result);

    }

    public function search_city(Request $request)
    {
        $term=$request->term;
        $data = City::where('name','LIKE',$term.'%')
            ->take(1)
            ->get();

        $result=array();
        foreach ($data as $key => $v){
            $result[]=['value' =>$v->name];
        }
      //  dd($result);

        return response()->json($result);



    }

    public function add_phone(Request $request)
    {
        $id_client= $request->id_client;
        $id_database = $request->id_database;
        $phonenumber=$request->phone;

        $result=array();

        $id_agent=Auth::user()->id;

//получение есть ли номер телефона на данном клиенте
        $data=DB::select('SELECT * FROM laravel.phones where phone=? AND id_client=?',[$phonenumber,$id_client]);
        //dump($data);
        if (count($data) == 0)
        {
            //нет добавляем
            $phone = new Phone();
            $phone->id_client=$id_client;
            $phone->id_agent=$id_agent;
            $phone->phone=$phonenumber;
            $phone->data_update=date(now());
            $phone->save();

        }else{

            //есть ничего не делаем

        }




        return response()->json($result);



    }



    public function search_phone(Request $request)
    {

        $phone=$request->phone;

        $data=DB::select('SELECT * FROM laravel.clients where id IN (select id_client from laravel.phones where phone=?)',[$phone]);
        $data_second = DB::select('SELECT * FROM laravel.second_databases where number_phone=?', [$phone]);


        if (count($data) == 0 && count($data_second) == 0) {

            return ' Клиента с таким номером телефона не найдено. Номер телефона <span id="search_phone">'.$phone.'</span>';
        }


        $response="";

        if(count($data)>0) {
            $response="Клиент с номером телефона ".$phone." найден";
            $response = "<p>База СКТ</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $fio = $v->fio;
                $data_rog = date("d/m/Y",strtotime($v->data_rog));


                $data_policy = DB::select('SELECT * FROM laravel.policy_clients where id_client=?', [$id]);
                if(count($data_policy)>0) {
                    foreach ($data_policy as $key => $v) {

                        $id_policy = $v->id;
                        $policy_name=$v->policy_name;

                        $last_data=DB::table('laravel.calls')->where('id_client',$id)->where('id_policy',$id_policy)->orderBy('id', 'desc')->limit(1)->pluck('data_update')->toArray();

                        $response .= '<tr>';
                        $response .= '<td >' . $id . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1">' . $fio . '</td>';
                        //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                        $response .= '<td>' . $data_rog . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                        $response .= '<td data="' . $id . '" database="1" id_policy="' . $id_policy . '">'.date("H:i:s d/m/Y",strtotime($last_data[0])).'</td>';
                        $response .= '</tr>';
                        $fio ="";
                        $data_rog="";

                    }

                }else{


                    $response .= '<tr>';
                    $response .= '<td>' . $id . '</td>';
                    $response .= '<td data="' . $id . '" database="1">' . $fio . '</td>';
                    //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                    $response .= '<td>' . $data_rog . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '</tr>';
                }

            }

            $response .= "</table>";
        }
        if(count($data_second)>0) {
            $response .= "<p>База заказчика</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data_second as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $id_policy = $v->id;
                $fio = $v->fio;
                $data_rog =date("d/m/Y",strtotime($v->data_rog));
                $policy_name=$v->policy_name;

                $response .= '<tr>';
                $response .= '<td>' . $id . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2">' . $fio . '</td>';
                //$response .= '<td  data="' . $id . '" database="2">' . $data_rog . '</td>';
                $response .= '<td>' . $data_rog . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                $response .= '<td  data="' . $id . '" database="2" id_policy="' . $id_policy . '">дата последнего</td>';
                $response .= '</tr>';


            }

            $response .= "</table>";
        }




        return $response;



    }


    public function search_callinfo(Request $request)
    {
        $fio=$request->fio;
        $datebirthd=$request->datebirthd;

        $response='';

        $numberpolicy=$request->numberpolicy;

        $numberphone=$request->numberphone;

        $response='';

        if($fio && $datebirthd) {

            $datebirthd=date("Y-m-d",strtotime(str_replace('/', '-', $datebirthd)));

           $data = DB::select('SELECT * FROM laravel.clients where fio=? AND data_rog=?', [$fio,$datebirthd]);

            if(count($data)>0) {
                $id_client=$data[0]->id;
            }else{
                return "Клиента с таким фио и датой рождения не найдено";
            }

        }
        if($numberpolicy) {
            $data = DB::select('SELECT * FROM laravel.clients where id IN (select id_client from laravel.policy_clients where policy_name=?)', [$numberpolicy]);
            if (count($data) > 0) {
                $id_client = $data[0]->id;
            } else {
                return "Клиента с таким номером полиса не найдено";
            }
        }

        if($numberphone) {
            $data=DB::select('SELECT * FROM laravel.clients where id IN (select id_client from laravel.phones where phone=?)',[$numberphone]);
            if(count($data)>0) {$id_client=$data[0]->id;
            }else{
                return "Клиента с таким телефоном не найдено";
            }

        }



        $data = DB::select('SELECT * FROM laravel.clients where id=?', [$id_client]);
        $data_police=DB::select('SELECT * FROM laravel.policy_clients where id_client=?', [$id_client]);



        if(count($data_police)>0) {


            foreach ($data_police as $key => $v) {

                $response.= "<b>ФИО</b>: ".$data[0]->fio."<br>";
                $response.= "<b>Дата рождения</b>: ".date("d/m/Y",strtotime($data[0]->data_rog))."<br>";

                //телефон
                $data_phone = DB::select('SELECT * FROM laravel.phones where id_client=?', [$id_client]);
                $phones='';
                foreach ($data_phone as $key => $phone) {

                 $phones.=" ".$phone->phone.".";

                }
                $response.= "<b>Телефон</b>: ".$phones."<br>";//банк

                $response.= "<b>Номер полиса</b>: ".$v->policy_name."<br>";
                $response.= "<b>Банк</b>: ".$v->bank."<br>";//банк
                //
                $response.= "<b>Дата полиса</b>: ".date("d/m/Y",strtotime($v->data_policy))."<br>";
                //тип кредитования

                $data_policyselect = DB::select('SELECT * FROM laravel.policies where id=?', [$v->policyselect]);
                if(count($data_policyselect)>0) {
                    $response .= "<b>Тип  кредитования</b>: " . $data_policyselect[0]->type_product . "<br>";
                }


                $response.= "<b>Сумма страховой премии</b>: ".$v->sum_kred."<br>";
                $response.= "<b>Сумма кредита</b>: ".$v->sum_kred."<br>";
                $response.= "<b>Срок действия</b>: ".$v->srok_dogov."<br>";
                $response.= "<b>Город</b>: ".$data[0]->city."<br>";

                if(strlen($v->comment1)>1) { $comment=$v->comment1.'. '.$v->comment2;}else{
                    $comment=$v->comment2;
                }
                $response.= "<b>Комментарий</b>: ". $comment."<br>";



                $data_call = DB::select('SELECT * FROM laravel.calls where id_policy=? AND id_client=? AND uniqueid is not null', [$v->id,$id_client]);

                if(count($data_call)>0) {

                    foreach ($data_call as $key => $call) {

                        $response.= date("H:i:s d/m/Y",strtotime($call->data_update)).'  <a href="/monitor/'.$call->uniqueid.'.mp3">Скачать</a>'.' агент '.$call->id_agent."<br>";

                    }
                }




                $response.="####################################"."<br><br>";;
            }


        }






        return $response;
    }


    public function realclientinfo(Request $request)
    {
        $id_policy=$request->id_policy;
        $id_client=$request->id_client;
        $response='';

if($id_client) {

    $response .= "<p><b>База СКТ</b></p>";
    $data =DB::select('SELECT * FROM laravel.client_changes where id_client=?',[$id_client]);

    $fio=$data[0]->fio;

    $response .="<p> ФИО : ".$data[0]->fio."</p>";
    $response .="<p> Дата рождения : ".date("d/m/Y",strtotime($data[0]->data_rog))."</p>";

}



        if( $id_policy) {

            $data =DB::select('SELECT * FROM laravel.policy_clients where id=?',[$id_policy]);

            $policy_name=$data[0]->policy_name;

            $response .="<p> Полис : ".$data[0]->policy_name."</p>";
            $response .="<p> Дата полиса : ".date("d/m/Y",strtotime($data[0]->data_policy))."</p>";

        }




        $data_second = DB::select('SELECT * FROM laravel.second_databases where fio=? AND policy_name=?', [$fio,$policy_name]);
        if (count($data_second) >0) {


            $response .= "<p><b> Найден в базе заказчика<b></p>";

        }



        return $response;
    }


    public function searchinfopolicy(Request $request)
    {

        $id_policy=$request->id_policy;

        $data =DB::select('SELECT * FROM laravel.policy_client_changes where id_policy=?',[$id_policy]);



        if (count($data) == 0) {

            return 'нет даты';
        }


        $response="";

        $comm1='-';
        $comm2='-';

        if(count($data)>0) {
            $response .= "<p>изменения комментариев</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>коммент 1</th><th>коммент2</th><th>время</th><th>номер агента</th><th>Разговор</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $comment1 = $v->comment1; if($comment1=='0') $comment1="";
                $comment2 = $v->comment2;
                $data_update =date("d/m/Y H:i:s ",strtotime($v->data_update));
                $id_agent=$v->id_agent;
                $uniqueid=$v->uniqueid;

                if($comm1!=$comment1 || $comm2!=$comment2) {
                    $response .= '<tr>';
                    $response .= '<td data="policy">' . $id . '</td>';
                    $response .= '<td data="policy">' . $comment1 . '</td>';
                    $response .= '<td data="policy">' . $comment2 . '</td>';
                    $response .= '<td data="policy">' . $data_update . '</td>';
                    $response .= '<td data="policy">' . $id_agent . '</td>';

                    if(!isset($uniqueid)){
                    $response .= '<td data="client">' . $uniqueid . '</td>';
                }else{
                    $response .= '<td data="client">' .'<a href="/monitor/'.$uniqueid.'.mp3">'.$uniqueid .'</a></td>';
                    }
                    $response .= '</tr>';
                }
                    $comm1=$comment1;
                    $comm2=$comment2;

            }

            $response .= "</table>";
        }




        return $response;



    }


    public function searchinfoclient(Request $request)
    {

        $id_client=$request->id_client;

        $data =DB::select('SELECT * FROM laravel.client_changes where id_client=?',[$id_client]);



        if (count($data) == 0) {

            return 'нет даты';
        }


        $response="";

        $fio_='-';
        $data_rog_='-';

        if(count($data)>0) {
            $response .= "<p>изменения данных клиента</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата рождения</th><th>время</th><th>номер агента</th><th>разговор</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $fio = $v->fio;
                $data_rog = date("d/m/Y",strtotime($v->data_rog));
                $data_update =date("d/m/Y H:i:s ",strtotime($v->data_update));
                $id_agent=$v->id_agent;
                $uniqueid=$v->uniqueid;

                if($fio_!=$fio || $data_rog_!=$data_rog) {
                    $response .= '<tr>';
                    $response .= '<td data="client">' . $id . '</td>';
                    $response .= '<td data="client">' . $fio . '</td>';
                    $response .= '<td data="client">' . $data_rog . '</td>';
                    $response .= '<td data="client">' . $data_update . '</td>';
                    $response .= '<td data="client">' . $id_agent . '</td>';

                    if(!isset($uniqueid)){
                        $response .= '<td data="client">' . $uniqueid . '</td>';
                    }else{
                        $response .= '<td data="client">' .'<a href="/monitor/'.$uniqueid.'.mp3">'.$uniqueid .'</a></td>';
                    }

                    $response .= '</tr>';
                }
                $fio_=$fio;
                $data_rog_=$data_rog;

            }

            $response .= "</table>";
        }




        return $response;



    }

    public function search_colorinfo(Request $request)
    {
$response='';

        $data = DB::select('SELECT * FROM laravel.color1s');
$count=count($data);


$response='<div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Описание цвета
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">

                                        <table border="1" class="dcf-table dcf-table-responsive dcf-table-bordered dcf-table-striped dcf-w-100%">
                                            <caption></caption>
                                            <thead>';

        $response.='<tr>';

        foreach ($data as $key => $v){

            $response.='<th scope="col" data-label="'.$v->color1.'">'.$v->color1.'</th>';
        }
        $response.='</tr>';

$response.='</thead>
                                            <tbody>';


        $response.='<tr>';

        foreach ($data as $key => $v){

            $response.='<td data-label="'.$v->color1.'"></td>';
        }
        $response.='</tr>';


        $response.='<tr>';

        $i=0;
        foreach ($data as $key => $v) {
            if ($i == 0) {
                $response .= '<td data-label="' . $v->color1 . '">Базовые страхи</td>';
            } else{
                $response .= '<td data-label="' . $v->color1 . '"></td>';
            }
                $i++;
        }
        $response.='</tr>';


        $response.='<tr>';
        foreach ($data as $key => $v){

            $response.='<td data-label="'.$v->color1.'">'.preg_replace("/\r\n/", "<br />", $v->description).'</td>';
        }
        $response.='</tr>';

        $i=0;
        foreach ($data as $key => $v) {
            if ($i == 0) {
                $response .= '<td data-label="' . $v->color1 . '">Базовые ценности</td>';
            } else{
                $response .= '<td data-label="' . $v->color1 . '"></td>';
            }
            $i++;
        }
        $response.='</tr>';
        $response.='<tr>';
        foreach ($data as $key => $v){




            $response.='<td data-label="'.$v->color1.'">'.str_replace('\r\n', '</br>', preg_replace("/\r\n/", "<br />", $v->description1)).'</td>';

        }
        $response.='</tr>';


        $i=0;
        foreach ($data as $key => $v) {
            if ($i == 0) {
                $response .= '<td data-label="' . $v->color1 . '">Ценностные слова</td>';
            } else{
                $response .= '<td data-label="' . $v->color1 . '"></td>';
            }
            $i++;
        }
        $response.='</tr>';
        $response.='<tr>';
        foreach ($data as $key => $v){

            $response.='<td data-label="'.$v->color1.'">'.preg_replace("/\r\n/", "<br />", $v->description2).'</td>';
        }
        $response.='</tr>';



        $response .='      </tbody>
                                        </table>



                                    </div>
                                </div>
                            </div>';


//dd(count($data));

return $response;

    }



    public function search_color1listing(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.color1s');



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "color1" => $v->color1);
        }
        //  dd($result);

        return response()->json($result);


    }
    public function search_color2listing(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.color2s');



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "color2" => $v->color2);
        }
        //  dd($result);

        return response()->json($result);


    }
    public function search_comment1listing(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.comment1s');



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "comment1" => $v->comment1);
        }
        //  dd($result);

        return response()->json($result);


    }

    public function search_templetesms(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.templates');



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "name" => $v->templetesmsname,"description" => $v->description);
        }
        //  dd($result);

        return response()->json($result);


    }


    public function search_banklisting(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.banks');



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "name" => $v->name);
        }
        //  dd($result);

        return response()->json($result);


    }

    public function search_productlisting(Request $request)
    {

        $bankid=$request->bankid;

        $data=DB::select('SELECT * FROM laravel.products where policy_id IN (select id from laravel.policies where bank_id=?)',[$bankid]);



        $result=array();
        foreach ($data as $key => $v){

            $result[]=array("id" => $v->id, "name" => $v->name_product);
        }
        //  dd($result);

        return response()->json($result);


    }



    public function search_fio(Request $request)
    {


        //$fio = $request->fio;
        $fio=preg_replace("/  +/"," ",$request->fio);


        $data = DB::select('SELECT * FROM laravel.clients where fio=?', [$fio]);
        $data_second = DB::select('SELECT * FROM laravel.second_databases where fio=?', [$fio]);


        if (count($data) == 0 && count($data_second) == 0) {

            return 'Клиента с таким ФИО не найдено';
        }


        $response="";
        if(count($data)>0) {
            $response = "<p>База СКТ</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $fio = $v->fio;
                $data_rog = date("d/m/Y",strtotime($v->data_rog));


                $data_policy = DB::select('SELECT * FROM laravel.policy_clients where id_client=?', [$id]);
                if(count($data_policy)>0) {
                    foreach ($data_policy as $key => $v) {

                        $id_policy = $v->id;
                        $policy_name=$v->policy_name;

                       // $last_data=DB::select('SELECT data_update FROM laravel.calls where id_client=? AND id_policy=? ORDER BY id DESC limit 1', [$id,$id_policy]);
                        $last_data=DB::table('laravel.calls')->where('id_client',$id)->where('id_policy',$id_policy)->orderBy('id', 'desc')->limit(1)->pluck('data_update')->toArray();

                       // dd($last_data[0]);

                        $response .= '<tr>';
                        $response .= '<td >' . $id . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1">' . $fio . '</td>';
                        //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                        $response .= '<td>' . $data_rog . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                        $response .= '<td data="' . $id . '" database="1" id_policy="' . $id_policy . '">'.date("H:i:s d/m/Y",strtotime($last_data[0])).'</td>';
                        $response .= '</tr>';
                        $fio ="";
                        $data_rog="";

                    }

                }else{


                    $response .= '<tr>';
                    $response .= '<td>' . $id . '</td>';
                    $response .= '<td data="' . $id . '" database="1">' . $fio . '</td>';
                    //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                    $response .= '<td>' . $data_rog . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '</tr>';
                }

            }

            $response .= "</table>";
        }
        if(count($data_second)>0) {
            $response .= "<p>База заказчика</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data_second as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $id_policy = $v->id;
                $fio = $v->fio;
                $data_rog =date("d/m/Y",strtotime($v->data_rog));
                $policy_name=$v->policy_name;

                $response .= '<tr>';
                $response .= '<td>' . $id . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2">' . $fio . '</td>';
                //$response .= '<td  data="' . $id . '" database="2">' . $data_rog . '</td>';
                $response .= '<td>' . $data_rog . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                $response .= '<td  data="' . $id . '" database="2" id_policy="' . $id_policy . '">дата последнего</td>';
                $response .= '</tr>';


            }

            $response .= "</table>";
        }










        return $response;
    }


    public function search_policy(Request $request)
    {

        $policy = $request->policy;



        $data = DB::select('SELECT * FROM laravel.clients where id IN (select id_client from laravel.policy_clients where policy_name=?)',[$policy]);
        $data_second = DB::select('SELECT * FROM laravel.second_databases where policy_name=?', [$policy]);


        if (count($data) == 0 && count($data_second) == 0) {

            return ' Клиента с таким номером полиса не найдено';
        }


        $response="";
        if(count($data)>0) {
            $response = "<p>База СКТ</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $fio = $v->fio;
                $data_rog = date("d/m/Y",strtotime($v->data_rog));


                $data_policy = DB::select('SELECT * FROM laravel.policy_clients where id_client=? AND policy_name=?', [$id,$policy]);
                if(count($data_policy)>0) {
                    foreach ($data_policy as $key => $v) {

                        $id_policy = $v->id;
                        $policy_name=$v->policy_name;

                        $last_data=DB::table('laravel.calls')->where('id_client',$id)->where('id_policy',$id_policy)->orderBy('id', 'desc')->limit(1)->pluck('data_update')->toArray();


                        $response .= '<tr>';
                        $response .= '<td >' . $id . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1">' . $fio . '</td>';
                        //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                        $response .= '<td>' . $data_rog . '</td>';
                        $response .= '<td bgcolor="#d4edda" data="' . $id . '" database="1" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                        $response .= '<td data="' . $id . '" database="1" id_policy="' . $id_policy . '">'.date("H:i:s d/m/Y",strtotime($last_data[0])).'</td>';
                        $response .= '</tr>';
                        $fio ="";
                        $data_rog="";

                    }

                }else{


                    $response .= '<tr>';
                    $response .= '<td>' . $id . '</td>';
                    $response .= '<td data="' . $id . '" database="1">' . $fio . '</td>';
                    //$response .= '<td data="' . $id . '" database="1">' . $data_rog . '</td>';
                    $response .= '<td>' . $data_rog . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '</tr>';
                }

            }

            $response .= "</table>";
        }
        if(count($data_second)>0) {
            $response .= "<p>База заказчика</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>ФИО</th><th>Дата Рождения</th><th>Полис</th><th>Время последнего звонка</th></tr>";

            foreach ($data_second as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;
                $id_policy = $v->id;
                $fio = $v->fio;
                $data_rog =date("d/m/Y",strtotime($v->data_rog));
                $policy_name=$v->policy_name;

                $response .= '<tr>';
                $response .= '<td>' . $id . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2">' . $fio . '</td>';
                //$response .= '<td  data="' . $id . '" database="2">' . $data_rog . '</td>';
                $response .= '<td>' . $data_rog . '</td>';
                $response .= '<td  bgcolor="#d4edda" data="' . $id . '" database="2" id_policy="' . $id_policy . '">' . $policy_name . '</td>';
                $response .= '<td  data="' . $id . '" database="2" id_policy="' . $id_policy . '">дата последнего</td>';
                $response .= '</tr>';


            }

            $response .= "</table>";
        }











        return $response;
    }

    public function searchinfoproduct(Request $request)
    {
        $id_product = $request->id_product;


        $response = "";
        $response1 = "";

//get product
        $data=DB::select('SELECT * FROM laravel.products where id=? limit 1',[$id_product]);
        if(count($data)>0) {

            $response .= "<p>Продукт</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>Продукт</th><th>Риски</th><th>Вид  кредита</th><th>Потеря работы</th><th>Страховые выалаты</th></tr>";





                $response .= '<tr>';
                $response .= '<td data="infoproduct">' . $data[0]->id . '</td>';
                $response .= '<td  data="infoproduct">' . $data[0]->name_product. '</td>';
                $response .= '<td  data="infoproduct">' . $data[0]->riski. '</td>';
                $response .= '<td  data="infoproduct">' . $data[0]->vid_kred. '</td>';
                $response .= '<td  data="infoproduct">' . $data[0]->poter_rab. '</td>';
                $response .= '<td  data="infoproduct">' . $data[0]->strah_vipl. '</td>';
                $response .= '</tr>';




            $response .= "</table>";


        }


        //bank и тип продукта
        $data = DB::select('SELECT * FROM laravel.policies WHERE id=?', [$data[0]->policy_id]);


        if(count($data)>0) {

            //  dd($data[0]->id);

            $data1 = DB::select('SELECT * FROM laravel.banks WHERE id =?', [$data[0]->bank_id]);
            $response1 .="<p> Банк : ".$data1[0]->name."</p>";
            $response1 .="<p> Тип Продукта : ".$data[0]->type_product."</p>";
        }


$response=$response1.$response;

return $response;
    }
    public function search_regexproduct(Request $request)
    {
        $policy = $request->policy;


        $response="";

        $data = DB::select('SELECT * FROM laravel.policies WHERE ? REGEXP regex_policy limit 1', [$policy]);


        if(count($data)>0) {

          //  dd($data[0]->id);

            $data1 = DB::select('SELECT * FROM laravel.banks WHERE id =?', [$data[0]->bank_id]);
            $response .="<p> Банк : ".$data1[0]->name."</p>";
            $response .="<p> Тип Продукта : ".$data[0]->type_product."</p>";
        }

        //$data = DB::select('SELECT * FROM laravel.policies WHERE ? REGEXP regex_policy', [$policy]);
        $data=DB::select('SELECT * FROM laravel.products where policy_id IN (SELECT id FROM laravel.policies WHERE ? REGEXP regex_policy)',[$policy]);

        if (count($data) == 0 ) {

            return ' Продуктов для данного вида полиса не найдено';
        }







        if(count($data)>0) {
            $response .= "<p>Продукты</p>";

            $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
            $response .= "<tr><th>ID</th><th>Продукт</th></tr>";

            foreach ($data as $key => $v) {
                //$result[]=['value' =>$v->name];

                $id = $v->id;

                $name_product = $v->name_product;



                $response .= '<tr>';
                $response .= '<td>' . $id . '</td>';
                $response .= '<td  data="' . $id . '"  regex="regex" bank="'.$data1[0]->id.'">' . $name_product. '</td>';
                $response .= '</tr>';


            }

            $response .= "</table>";
        }

return $response;

    }







    public function search_client(Request $request)
    {

        $id_client= $request->id_client;
        $id_database = $request->id_database;
        $id_policy=$request->id_policy;

        $result=array();

if($id_database==1) {
    $data = Client::where('id', $id_client)->get();

    foreach ($data as $key => $v) {
        $result['id'] = [$v->id];
        $result['fio'] = [$v->fio];
        $result['data_rog'] = date("d/m/Y",strtotime($v->data_rog));
        $result['color1'] = [$v->color1];
        $result['color2'] = [$v->color2];
        $result['city'] = [$v->city];
        $result['region'] = [$v->region];
        $result['rodstvenniki'] = [$v->rodstvenniki];


    }

    $data = Phone::where('id_client', $id_client)->get();
    //dump($data);
    $i = 0;
    foreach ($data as $key => $v) {
        $result['phone'][$i++] = [$v->phone];
    }

    if(isset($id_policy)) {



        $data = PolicyClient::where('id', $id_policy)->get();
        // dd($data);
        foreach ($data as $key => $v) {
            //$result['phone']=[$v->phone];
            $result['polis'] = [$v->policy_name];
            $result['data_polis'] = date("d/m/Y",strtotime($v->data_policy));


            $result['bankselect'] = [$v->bankselect];
            $result['policyselect'] = [$v->policyselect];

            $result['sum_kred'] = [$v->sum_kred];
            $result['sum_strah'] = [$v->sum_strah];
            $result['srok_dogov'] = [$v->srok_dogov];

            $result['otkaz'] = [$v->otkaz];
            $result['reshenie'] = [$v->reshenie];
            $result['udergal'] = [$v->udergal];
            $result['comment1'] = [$v->comment1];
            $result['comment2'] = [$v->comment2];

        }
    }else{
        $result['bankselect'] = 0;
        $result['policyselect'] = 0;

        $result['comment1'] = 0;

    }

}


        if($id_database==2) {

            $data = DB::select('SELECT * FROM laravel.second_databases where id=?', [$id_client]);


            foreach ($data as $key => $v) {
                $result['id'] = [$v->id];
                $result['fio'] = [$v->fio];
                $result['data_rog'] =date("d/m/Y",strtotime($v->data_rog));

                if(isset($id_policy)) {
                    $result['polis'] = [$v->policy_name];
                    $result['data_polis'] = date("d/m/Y", strtotime($v->data_policy));
                    $result['srok_dogov'] = [$v->srok_dogov];
                }
                $result['phone'] = [$v->number_phone];


                $result['color1'] = 0;
                $result['color2'] = 0;
                $result['bankselect'] = 0;
                $result['policyselect'] = 0;
                $result['comment1'] = 0;
            }




        }




        return  response()->json($result);



    }


    public function search_smsonphone(Request $request)
    {
        $content="";
        $phonelist= $request->phone;


        $sms_phone = explode(",", $phonelist);
        $count=count($sms_phone);


        for($i=0;$i<$count;$i++)
        {
            $data=DB::select('SELECT templatesms FROM laravel.sms_polls where tonumber=? ',[$sms_phone[$i]]);




        }





        dd($data);
    }

        public function search_sendsms(Request $request)
    {


        $to= $request->numberphonesms;
        $textsms = $request->textsms;
        $templatesms = $request->templatesms;
        $date_now = date(now());
        $id_agent=Auth::user()->id;



        $ch = curl_init("https://sms.ru/sms/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "api_id" => "65A60618-349D-D69A-C8E3-EC90CAEEE8B5",
            "to" => $to, // До 100 штук до раз
            "msg" => $textsms, // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",

            "json" => 1 // Для получения более развернутого ответа от сервера
        )));
        $body = curl_exec($ch);
        curl_close($ch);



        $json = json_decode($body);
/*
 $json=   '{
            "status": "OK",
    "status_code": 100,
    "sms": {
            "89513267099": {
                "status": "OK",
            "status_code": 100,
            "sms_id": "202023-1000000",
            "cost": "2.79"
        }
    },
    "balance": 7.21
}';
*/









        if ($json) { // Получен ответ от сервера
          //  print_r($json); // Для дебага
            if ($json->status == "OK") { // Запрос выполнился
                foreach ($json->sms as $phone => $data) { // Перебираем массив СМС сообщений
                    if ($data->status == "OK") { // Сообщение отправлено
                       // echo "Сообщение на номер $phone успешно отправлено. ";
                       // echo "ID сообщения: $data->sms_id. ";
                        $result['data'] = "yes";
                   DB::insert('insert into laravel.sms_polls (id_agent, tonumber ,textsms , id_sms,templatesms,timesms) values (?, ? ,? ,? ,? ,?)', [$id_agent,$to,$textsms,$data->sms_id,$templatesms,$date_now]);
                       // dd($data);
                    } else { // Ошибка в отправке
                       // echo "Сообщение на номер $phone не отправлено. ";
                       // echo "Код ошибки: $data->status_code. ";
                       // echo "Текст ошибки: $data->status_text. ";
                       // echo "";
                        $result['data'] = "no";
                        $result['code']=$data->status_code;
                        $result['texterror']=$data->status_text;
                    }
                }

               // echo "Баланс после отправки: $json->balance руб.";
               // echo "";
            } else { // Запрос не выполнился (возможно ошибка авторизации, параметрах, итд...)

                //echo "Код ошибки: $json->status_code. ";
                //echo "Текст ошибки: $json->status_text. ";
                $result['data'] = "no";
                $result['code']=$json->status_code;
                $result['texterror']=$json->status_text;
            }
        } else {

           // echo "Запрос не выполнился. Не удалось установить связь с сервером. ";
            $result['data'] = "no";
            $result['code']= "666";
            $result['texterror']="Запрос не выполнился. Не удалось установить связь с сервером. ";
        }

        //$result['data'] = "yes";
      //  dd($result);
        return  response()->json($result);
    }

    public function search_newbell(Request $request)
    {

        $data=DB::table('laravel.others')->where('markread','false')->count();

        if($data==0) {
            $result['data'] = "no";
        }else{
            $result['data'] = "yes";
    }
        return  response()->json($result);
    }
    public function search_newcall(Request $request)
    {

        $id_agent=Auth::user()->id;
        $agent_internalphone=Auth::user()->internalphone;
        $date_now=date(now());

        $data = DB::select('SELECT * FROM laravel.asterisk_calls WHERE tonumber=? AND enabled=?', [$agent_internalphone,1]);
        $result=array();

        if(count($data)>0) {


            foreach ($data as $key => $v) {
                $result['data'] = "yes";
                $result['fromnumber'] = [$v->fromnumber];
                $result['id'] = [$v->id];
                $result['tonumber'] = [$v->tonumber];
                $result['uniqueid'] = [$v->uniqueid];
            }

            $affected = DB::table('laravel.asterisk_calls')->where('id',$v->id)->update(['enabled' => 0]);


            //dd($result);
        }else{
            $result['data'] = "no";
        }

        return  response()->json($result);

    }

    public function search_makenewcall(Request $request)
    {


        $fromnumber = $request->fromnumber;
        $tonumber = $request->tonumber;
        $uniqueid = $request->uniqueid;
        $date_now = date(now());

        if($fromnumber && $tonumber &&  $uniqueid)
        {
            DB::insert('insert into laravel.asterisk_calls (fromnumber, tonumber , uniqueid , calldate) values (?, ? ,? ,?)', [$fromnumber,$tonumber,$uniqueid,$date_now]);
        }





    }
/////////////////////////////////////////////////////////////////////////
///
///
    public function search_user(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.users');



        $response='';
        foreach ($data as $key => $v){

            $response.="<option value='".$v->id."'>".$v->nickname."(#".$v->id.")"."(".$v->internalphone.")"."</option>";
        }


        return $response;


    }
    public function search_group(Request $request)
    {



        $data = DB::select('SELECT DISTINCT(type_product) AS type_product FROM laravel.policies WHERE type_product is not null');



        $response='';
        foreach ($data as $key => $v){

            $response.="<option value='".$v->type_product."'>".$v->type_product."</option>";
        }


        return $response;


    }

    public function search_colorclient(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.color1s');



        $response='';
        foreach ($data as $key => $v){

            $response.="<option value='".$v->color1."'>".$v->color1."</option>";
        }


        return $response;


    }

    public function search_bankbank(Request $request)
    {



        $data = DB::select('SELECT * FROM laravel.banks');



        $response='';
        foreach ($data as $key => $v){

            $response.="<option value='".$v->id."'>".$v->name."</option>";
        }


        return $response;


    }


    public function search_product_bank(Request $request)
    {

        $data=$request->all();


 $bank=array();


        foreach($data as $key => $val ) {



            if ( strncmp($key,"bank",4)==0) {
                $bank[]=$val;
            }

            }




        $data=DB::select("SELECT * FROM laravel.products where policy_id IN (select id from laravel.policies where bank_id IN (".implode(',', array_map('intval', $bank)) ."))");


        $response='';
        foreach ($data as $key => $v){

            $response.="<option value='".$v->id."'>".$v->name_product."</option>";
        }


        return $response;


    }



    public function change_incorrect(Request $request)
    {

$response='';





        if($request->secondid)
        {
            $data=DB::select('SELECT * FROM laravel.second_databases where id = '.$request->secondid);


            $fio=$data[0]->fio;
            $policy_name=$data[0]->policy_name;
            $data_rog=$data[0]->data_rog;
            $datepolicy=$data[0]->data_policy;
            //dd($policy_name);


            $id_agent=Auth::user()->id;
            $date_now=date(now());

            if($request->baseid){

                $affected = DB::table('laravel.clients')->where('id',$request->baseid)->update(['fio' => $fio,'data_rog'=>$data_rog]);

            }

            if($request->policyid)
            {
                $affected = DB::table('laravel.policy_clients')->where('id',$request->policyid)->update(['policy_name' => $policy_name]);
            }else{

                $id_policy = DB::table('laravel.policy_clients')
                    ->insertGetId(['id_client' => $request->baseid, 'policy_name' => $policy_name, 'data_policy' => $datepolicy, 'id_agent' => $id_agent, 'data_update' => $date_now]);

            }


        }

       // if($request->baseid)
       // if($request->policyid)






            return $response;


    }

    }


