<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




   private function encodeCSV(&$value, $key){
        $value = iconv('UTF-8', 'Windows-1251', $value);
    }

    public function index()
    {
        //
        return view('admin.report.report_agent');
    }

    public function report_agent()
    {
        //

        return view('admin.report.report_agent');
    }


    public function report_agent_csv(Request $request)
    {
        $fp = fopen("php://output", "w");


        $from='';
        $to='';

        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $date_update_calls="calls.data_update BETWEEN '".$from."' AND '".$to."'";


        $file_name='Report_agent_'.$from.'_'.$to.".csv";

        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        header('Content-type: text/html; charset=cp1251');


        $stat = array();
        $stat=[];
        $bigstat = array();
        $bigstat=[];


        $data           =       array();

        $user =array();
        $names =array();
        $color=array();
        $group=array();

        $response='';


        $data=$request->all();





        foreach($data as $key => $val ) {



            if ( strncmp($key,"reqs",4)==0) {
                $user[]=$val;
            }
            if ( strncmp($key,"color",5)==0) {
                $color[]=$val;
            }
            if ( strncmp($key,"group",5)==0) {
                $group[]=$val;
            }

        }











        $colors='';

        foreach ($color as $v) {
            $colors.="clients.color1='".$v."' OR ";
        }
        if(strlen($colors)>0) $colors=mb_substr($colors, 0, -4);


        $groups='';

        foreach ($group as $v) {
            $groups.="policies.type_product='".$v."' OR ";
        }
        if(strlen($groups)>0) $groups=mb_substr($groups, 0, -4);


        ///////////////////////////////////////////

        if(count($user)==0)
        {
             $data = DB::select('SELECT * FROM laravel.users');


              foreach ($data as $v) {
              $user[]=$v->id;
              }

        }




        foreach ($user as $v) {


            $data = DB::select('SELECT nickname FROM laravel.users WHERE id=?', [$v]);


            $name=$data[0]->nickname;
            $names[]=$name;
            $sql='';
            $sql="SELECT laravel.calls.*,
    laravel.policies.type_product,
    laravel.clients.color1
From
    laravel.calls LEFT Join
    laravel.clients On laravel.clients.id = laravel.calls.id_client LEFT Join
    laravel.policies On laravel.policies.id = laravel.calls.id_policy where ";
            $sql.="(calls.id_agent=".$v;
            if(strlen($groups)>0) $sql.=" AND (".$groups.")";
            if(strlen($colors)>0) $sql.=" AND (".$colors.")";
            $sql.=" AND ".$date_update_calls.")";

            $data = DB::select($sql);

            #

            for($i=0;$i<24;$i++ ) $stat[$i]=0;
            foreach ($data as $call) {


                $data_zvonka=date("G",strtotime($call->data_update));
                $temp=0;
                $temp=$stat[$data_zvonka];
                $stat[$data_zvonka]=$temp+1;
            }

            $bigstat[$name]=$stat;


        }



        //  dump($bigstat);



$csv=array();

        $csv[]="Час/Оператор";
        foreach ($names as $key => $val ) {
            $csv[]= $val;
        }
        $csv[]="Итого";


        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');


        $response .= '<tr>';
        for($i=7;$i<21;$i++ )
        {
            $csv=array();
            //$result[]=['value' =>$v->name];

            $temp=0;
            $csv[]= $i;
            foreach ($names as $key => $val ) {
                $csv[]=$bigstat[$val][$i];
                $temp=$temp+$bigstat[$val][$i];
            }
            $csv[]=$temp;

            array_walk($csv, array('self', 'encodeCSV'));
            fputcsv($fp, $csv,';');

        }

        $csv=array();

        $csv[]= 'Итого';
//
        $fullsumm=0;
        foreach ($names as $key => $val ) {
            $temp=0;
            for($i=7;$i<21;$i++ )
            {
                //$result[]=['value' =>$v->name];



                $temp=$temp+$bigstat[$val][$i];

            }
            $csv[]= $temp;
            $fullsumm=$fullsumm+$temp;


        }
        $csv[]= $fullsumm;

        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');
        //




















        fclose($fp);
        exit;



    }
    public function report_agent_(Request $request)
    {

        $from='';
        $to='';

        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $date_update_calls="calls.data_update BETWEEN '".$from."' AND '".$to."'";


$stat = array();
$stat=[];
        $bigstat = array();
        $bigstat=[];


        $data           =       array();

        $user =array();
        $names =array();
        $color=array();
        $group=array();

        $response='';


        $data=$request->all();





        foreach($data as $key => $val ) {



            if ( strncmp($key,"reqs",4)==0) {
                $user[]=$val;
            }
            if ( strncmp($key,"color",5)==0) {
                $color[]=$val;
            }
            if ( strncmp($key,"group",5)==0) {
                $group[]=$val;
            }

        }








/*
        while ($name = current($data)) {


            if ( strncmp(key($data),"reqs",4)==0) {
            $user[]=$name;
            }
            if ( strncmp(key($data),"color",5)==0) {
                $color[]=$name;
            }
            if ( strncmp(key($data),"group",5)==0) {
                $group[]=$name;
            }
            next($data);
        }

*/



        $colors='';

        foreach ($color as $v) {
         $colors.="clients.color1='".$v."' OR ";
        }
        if(strlen($colors)>0) $colors=mb_substr($colors, 0, -4);


        $groups='';

        foreach ($group as $v) {
            $groups.="policies.type_product='".$v."' OR ";
        }
        if(strlen($groups)>0) $groups=mb_substr($groups, 0, -4);


        ///////////////////////////////////////////

        if(count($user)==0)
        {
            $data = DB::select('SELECT * FROM laravel.users');


            foreach ($data as $v) {
                $user[]=$v->id;
            }

        }



        foreach ($user as $v) {

            $data = DB::select('SELECT nickname FROM laravel.users WHERE id=?', [$v]);


            $name=$data[0]->nickname;
$names[]=$name;
            $sql='';
            $sql="SELECT laravel.calls.*,
    laravel.policies.type_product,
    laravel.clients.color1
From
    laravel.calls LEFT Join
    laravel.clients On laravel.clients.id = laravel.calls.id_client LEFT Join
    laravel.policies On laravel.policies.id = laravel.calls.id_policy where ";
            $sql.="(calls.id_agent=".$v;
            if(strlen($groups)>0) $sql.=" AND (".$groups.")";
            if(strlen($colors)>0) $sql.=" AND (".$colors.")";
            $sql.=" AND ".$date_update_calls.")";

//SELECT clients.fio as fio,clients.id as id,clients.data_update as update_client,policy_clients.data_update as update_policy,type_product,clients.id_agent as agent_client,policy_clients.id_agent as agent_policy FROM laravel.clients LEFT Join laravel.policy_clients On clients.id = policy_clients.id_client LEFT Join policies On policies.id = policy_clients.policyselect where
// (clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND clients.data_update BETWEEN '2010-08-14' AND '2020-08-01')
// OR
// (policy_clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND policy_clients.data_update BETWEEN '2010-08-14' AND '2020-08-01');
////
            $data = DB::select($sql);

            #

for($i=0;$i<24;$i++ ) $stat[$i]=0;
            foreach ($data as $call) {


                $data_zvonka=date("G",strtotime($call->data_update));
$temp=0;
$temp=$stat[$data_zvonka];
                    $stat[$data_zvonka]=$temp+1;
            }

            $bigstat[$name]=$stat;
















        }



      //  dump($bigstat);





        $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
        $response .= "<tr><th>Час/Оператор</th>";
        foreach ($names as $key => $val ) {
            $response .= '<th>' .$val. '</th>';
        }
        $response .= "<th>Итого</th></tr>";

        $response .= '<tr>';
        for($i=7;$i<21;$i++ )
        {
            //$result[]=['value' =>$v->name];

            $temp=0;
            $response .= '<td>' . $i. '</td>';
            foreach ($names as $key => $val ) {
                $response .= '<td>' . $bigstat[$val][$i] . '</td>';
                $temp=$temp+$bigstat[$val][$i];
            }
            $response .= '<td>' . $temp. '</td>';
         //   $response .= '<td>' . $bigstat['sandal'][$i] . '</td>';




            $response .= '</tr>';

        }
        $response .= '<td>Итого</td>';
//
        $fullsumm=0;
        foreach ($names as $key => $val ) {
            $temp=0;
            for($i=7;$i<21;$i++ )
        {
            //$result[]=['value' =>$v->name];



                $temp=$temp+$bigstat[$val][$i];

            }
            $response .= '<td>' . $temp. '</td>';
            $fullsumm=$fullsumm+$temp;


        }
        $response .= '<td>' . $fullsumm. '</td>';
//
        $response .= "</table>";


        $response.='<button name="create_excel" id="create_excel" class="btn btn-success">Сохранить файл</button>';










        return response()->json($response);

      //  return $response;
    }

    public function report_bank_(Request $request)
    {

        $from='';
        $to='';

        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $data_update="clients.data_update BETWEEN '".$from."' AND '".$to."'";

        //summa kredita

        if($request->kred_from)
        {
            $kred_from=$request->kred_from;
        }else{
            $kred_from=0;
        }

        if($request->kred_to)
        {
            $kred_to=$request->kred_to;
        }else{
            $kred_to=900000000;
        }

        $summ_kred="policy_clients.sum_kred >= $kred_from AND policy_clients.sum_kred <= $kred_to";

        //summa strah

        if($request->strah_from)
        {
            $strah_from=$request->strah_from;
        }else{
            $strah_from=0;
        }

        if($request->strah_to)
        {
            $strah_to=$request->strah_to;
        }else{
            $strah_to=900000000;
        }

        $summ_strah="policy_clients.sum_strah >= $strah_from AND policy_clients.sum_strah <= $strah_to";





        $data           =       array();

        $user =array();
        $group=array();
        $banks=array();
        $products=array();
        $citys=array();
        $masks=array();


        $response='';


        $data=$request->all();





        foreach($data as $key => $val ) {



            if ( strncmp($key,"reqs",4)==0) {
                $user[]=$val;
            }

            if ( strncmp($key,"group",5)==0) {
                $group[]=$val;
            }

            if ( strncmp($key,"bank",4)==0) {
                $banks[]=$val;
            }

            if ( strncmp($key,"product",7)==0) {
                $products[]=$val;
            }

            if ( strncmp($key,"city",4)==0) {
                $citys[]=$val;
            }
            if ( strncmp($key,"regex",5)==0) {
                $masks[]=$val;
            }
        }


        $user_str='';
        foreach ($user as $v) {
            $user_str.="clients.id_agent='".$v."' OR ";
        }
        if(strlen($user_str)>0) $user_str=mb_substr($user_str, 0, -4);


        $group_str='';
        foreach ($group as $v) {
            $group_str.="policies.type_product='".$v."' OR ";
        }
        if(strlen($group_str)>0) $group_str=mb_substr($group_str, 0, -4);


        $bank_str='';
        foreach ($banks as $v) {
            $bank_str.="policy_clients.bankselect='".$v."' OR ";
        }
        if(strlen($bank_str)>0) $bank_str=mb_substr($bank_str, 0, -4);


        $product_str='';
        foreach ($products as $v) {
            $product_str.="policy_clients.policyselect='".$v."' OR ";
        }
        if(strlen($product_str)>0) $product_str=mb_substr($product_str, 0, -4);


        $city_str='';
        foreach ($citys as $v) {
            $city_str.="clients.city='".$v."' OR ";
        }
        if(strlen($city_str)>0) $city_str=mb_substr($city_str, 0, -4);


        $regex_str='';
        foreach ($masks as $v) {
            $regex_str.="policy_clients.policy_name like '%".$v."%' OR ";
        }
        if(strlen($regex_str)>0) $regex_str=mb_substr($regex_str, 0, -4);



        ///////////////////////////////////////////


            $sql='';
            $sql="Select
    *, laravel.clients.id AS idd
From
    laravel.clients LEFT Join
    laravel.policy_clients On laravel.policy_clients.id_client = laravel.clients.id LEFT Join
    laravel.policies On laravel.policies.id = laravel.policy_clients.policyselect where ";

            $sql.= "(".$data_update;
            if(strlen($user_str)>0) $sql.=" AND (".$user_str.")";
            if(strlen($group_str)>0) $sql.=" AND (".$group_str.")";
            if(strlen($bank_str)>0) $sql.=" AND (".$bank_str.")";
            if(strlen($product_str)>0) $sql.=" AND (".$product_str.")";
            if(strlen($city_str)>0) $sql.=" AND (".$city_str.")";
            if(strlen($regex_str)>0) $sql.=" AND (".$regex_str.")";
               $sql.=" AND (".$summ_kred.")";
               $sql.=" AND (".$summ_strah.") )";



//SELECT clients.fio as fio,clients.id as id,clients.data_update as update_client,policy_clients.data_update as update_policy,type_product,clients.id_agent as agent_client,policy_clients.id_agent as agent_policy FROM laravel.clients LEFT Join laravel.policy_clients On clients.id = policy_clients.id_client LEFT Join policies On policies.id = policy_clients.policyselect where
// (clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND clients.data_update BETWEEN '2010-08-14' AND '2020-08-01')
// OR
// (policy_clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND policy_clients.data_update BETWEEN '2010-08-14' AND '2020-08-01');
////
///
///
///
///



            $data = DB::select($sql);

        $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
        $response .= "<tr><th>Дата</th><th>Оператор</th><th>Группа</th><th>ФИО клиента</th><th>ДР клиента</th><th>Полис</th><th>Банк</th><th>Город</th><th>Продукт</th><th>Риски</th><th>Сумма кредита</th><th>Сумма страховки</th><th>Решение</th><th>Номер клиента</th></tr>";

        foreach ($data as $v) {

            $response .= '<tr>';

            $response .= '<td>' . date("h:i:s d/m/Y",strtotime($v->data_update)) . '</td>';
            $response .= '<td>' . $v->id_agent . '</td>';
            $response .= '<td>' . $v->type_product . '</td>';
            $response .= '<td>' . $v->fio . '</td>';
            $response .= '<td>' .date("d/m/Y",strtotime($v->data_rog)) . '</td>';


            $response .= '<td>' . $v->policy_name . '</td>';
            $response .= '<td>' . $v->bank . '</td>';
            $response .= '<td>' . $v->city . '</td>';

            $response .= '<td>' . $v->prod_name . '</td>';
            $response .= '<td>' . $v->riski. '</td>';

            $response .= '<td>' . $v->sum_kred. '</td>';
            $response .= '<td>' . $v->sum_strah. '</td>';

            $response .= '<td>' . $v->reshenie. '</td>';
            $response .= '<td>' . $v->idd. '</td>';

            $response .= '</tr>';

        }



        $response .= "</table>";


        $response.='<button name="create_excel" id="create_excel" class="btn btn-success">Сохранить файл</button>';



        return response()->json($response);

        //  return $response;
    }


    public function report_bank_csv(Request $request)
    {

        $fp = fopen("php://output", "w");


        $from='';
        $to='';

        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $data_update="clients.data_update BETWEEN '".$from."' AND '".$to."'";


        $file_name='Report_bank_'.$from.'_'.$to.".csv";

        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        header('Content-type: text/html; charset=cp1251');



        //summa kredita

        if($request->kred_from)
        {
            $kred_from=$request->kred_from;
        }else{
            $kred_from=0;
        }

        if($request->kred_to)
        {
            $kred_to=$request->kred_to;
        }else{
            $kred_to=900000000;
        }

        $summ_kred="policy_clients.sum_kred >= $kred_from AND policy_clients.sum_kred <= $kred_to";

        //summa strah

        if($request->strah_from)
        {
            $strah_from=$request->strah_from;
        }else{
            $strah_from=0;
        }

        if($request->strah_to)
        {
            $strah_to=$request->strah_to;
        }else{
            $strah_to=900000000;
        }

        $summ_strah="policy_clients.sum_strah >= $strah_from AND policy_clients.sum_strah <= $strah_to";





        $data           =       array();

        $user =array();
        $group=array();
        $banks=array();
        $products=array();
        $citys=array();
        $masks=array();


        $response='';


        $data=$request->all();





        foreach($data as $key => $val ) {



            if ( strncmp($key,"reqs",4)==0) {
                $user[]=$val;
            }

            if ( strncmp($key,"group",5)==0) {
                $group[]=$val;
            }

            if ( strncmp($key,"bank",4)==0) {
                $banks[]=$val;
            }

            if ( strncmp($key,"product",7)==0) {
                $products[]=$val;
            }

            if ( strncmp($key,"city",4)==0) {
                $citys[]=$val;
            }
            if ( strncmp($key,"regex",5)==0) {
                $masks[]=$val;
            }
        }


        $user_str='';
        foreach ($user as $v) {
            $user_str.="clients.id_agent='".$v."' OR ";
        }
        if(strlen($user_str)>0) $user_str=mb_substr($user_str, 0, -4);


        $group_str='';
        foreach ($group as $v) {
            $group_str.="policies.type_product='".$v."' OR ";
        }
        if(strlen($group_str)>0) $group_str=mb_substr($group_str, 0, -4);


        $bank_str='';
        foreach ($banks as $v) {
            $bank_str.="policy_clients.bankselect='".$v."' OR ";
        }
        if(strlen($bank_str)>0) $bank_str=mb_substr($bank_str, 0, -4);


        $product_str='';
        foreach ($products as $v) {
            $product_str.="policy_clients.policyselect='".$v."' OR ";
        }
        if(strlen($product_str)>0) $product_str=mb_substr($product_str, 0, -4);


        $city_str='';
        foreach ($citys as $v) {
            $city_str.="clients.city='".$v."' OR ";
        }
        if(strlen($city_str)>0) $city_str=mb_substr($city_str, 0, -4);


        $regex_str='';
        foreach ($masks as $v) {
            $regex_str.="policy_clients.policy_name like '%".$v."%' OR ";
        }
        if(strlen($regex_str)>0) $regex_str=mb_substr($regex_str, 0, -4);




        ///////////////////////////////////////////


        $sql='';
        $sql="Select
    *, laravel.clients.id AS idd
From
    laravel.clients LEFT Join
    laravel.policy_clients On laravel.policy_clients.id_client = laravel.clients.id LEFT Join
    laravel.policies On laravel.policies.id = laravel.policy_clients.policyselect where ";

        $sql.= "(".$data_update;
        if(strlen($user_str)>0) $sql.=" AND (".$user_str.")";
        if(strlen($group_str)>0) $sql.=" AND (".$group_str.")";
        if(strlen($bank_str)>0) $sql.=" AND (".$bank_str.")";
        if(strlen($product_str)>0) $sql.=" AND (".$product_str.")";
        if(strlen($city_str)>0) $sql.=" AND (".$city_str.")";
        if(strlen($regex_str)>0) $sql.=" AND (".$regex_str.")";
        $sql.=" AND (".$summ_kred.")";
        $sql.=" AND (".$summ_strah.") )";



//SELECT clients.fio as fio,clients.id as id,clients.data_update as update_client,policy_clients.data_update as update_policy,type_product,clients.id_agent as agent_client,policy_clients.id_agent as agent_policy FROM laravel.clients LEFT Join laravel.policy_clients On clients.id = policy_clients.id_client LEFT Join policies On policies.id = policy_clients.policyselect where
// (clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND clients.data_update BETWEEN '2010-08-14' AND '2020-08-01')
// OR
// (policy_clients.id_agent=12
// AND (policies.type_product='POS' OR policies.type_product='PIL')
// AND (clients.color1='Синий' OR clients.color1='Красный')
// AND policy_clients.data_update BETWEEN '2010-08-14' AND '2020-08-01');
////
        $data = DB::select($sql);

        $csv=array();


        $csv[]= "Дата";
        $csv[]= "Оператор";
        $csv[]= "Группа";
        $csv[]= "ФИО клиента";
        $csv[]= "ДР клиента";
        $csv[]= "Полис";
        $csv[]= "Банк";
        $csv[]= "Город";
        $csv[]= "Продукт";
        $csv[]= "Риски";
        $csv[]= "Сумма кредита";
        $csv[]= "Сумма страховки";
        $csv[]= "Решение";
        $csv[]= "Номер клиента";

        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');

        foreach ($data as $v) {

            $csv=array();

            $csv[]= date("h:i:s  d/m/Y",strtotime($v->data_update))  ;
            $csv[]= $v->id_agent ;
            $csv[]= $v->type_product;
            $csv[]= $v->fio;
            $csv[]= date("d/m/Y",strtotime($v->data_rog)) ;

            $csv[]= $v->policy_name;
            $csv[]= $v->bank ;
            $csv[]= $v->city ;

            $csv[]= $v->prod_name;
            $csv[]= $v->riski;

            $csv[]= $v->sum_kred;
            $csv[]= $v->sum_strah;

            $csv[]= $v->reshenie;
            $csv[]= $v->idd;


            array_walk($csv, array('self', 'encodeCSV'));
            fputcsv($fp, $csv,';');
        }




        fclose($fp);
        exit;








        //  return $response;
    }





        public function report_bank()
    {
        //

        return view('admin.report.report_bank');
    }



    public function report_percent()
    {
        //

        return view('admin.report.report_percent');
    }

    public function report_incorrect()
    {
        //

        return view('admin.report.report_incorrect');
    }


    public function report_percent_(Request $request)
    {



        $from='';
        $to='';
        $response='';


        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $data_update="policy_clients.data_update BETWEEN '".$from."' AND '".$to."'";


        $percent=array();


        $data=$request->all();
        foreach($data as $key => $val ) {


            if (strncmp($key, "percent", 7) == 0) {
                $percent[] = $val;
            }
        }

        if(count($percent)==0)
        {
            for($i=0;$i<11;$i++) $percent[] = $i;
        }


        $data = DB::select('SELECT * FROM laravel.banks');



        $banks=array();
        foreach ($data as $key => $v){

            $banks[]=array("id" => $v->id, "name" => $v->name);
        }






        $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
        $response .= "<tr><th>Банк</th>";
        foreach ($percent as $key => $val ) {
            if($val!=10) {
                $response .= '<th>' . ($val) * 5 . "% - " . (($val * 5) + 5) . '%</th>';
            }else{
                $response .= '<th>' .($val)*5 .'% - и более</th>';
            }


        }
        $response .= "<th>Итого</th></tr>";


        foreach ($banks as $key => $val ) {


            $response .= '<tr><td>' .$val['name'].'</td>';


            $temp_bank=0;
            foreach ($percent as $key => $per ) {


               $sql='';
               $sql= 'Select * From policy_clients WHERE ';
               $sql.= $data_update;
               $sql.=' AND (sum_strah/sum_kred)*100 >= '.($per * 5).' AND (sum_strah/sum_kred)*100 < '.(($per * 5) + 5);
               $sql.=' AND bankselect='.$val['id'];

                $data = DB::select($sql);

                $temp_bank=$temp_bank+count($data);
                $response .= '<td>' .count($data).'</td>';


                $bigstat[$val['id']][$per]=count($data);
            }



            $response .= '<td>' .$temp_bank.'</td>';
            $response .= "</tr>";

        }


        $response .= "<tr><td>Итого</td>";


        $summ_final=0;
        foreach ($percent as $key => $per ) {


            $temp_final=0;

            foreach ($banks as $key => $val ) {

                $temp_final=$temp_final+$bigstat[$val['id']][$per];



            }

            $response .= '<td>' .$temp_final.'</td>';
            $summ_final=$summ_final+$temp_final;
        }

        $response .= '<td>' .$summ_final.'</td>';
        $response .= "</tr>";







        $response .= "</table>";








        $response.='<button name="create_excel" id="create_excel" class="btn btn-success">Сохранить файл</button>';







        return response()->json($response);

    }


    public function report_percent_csv(Request $request)
    {

        $fp = fopen("php://output", "w");

        $from='';
        $to='';
        $response='';


        if($request->from)
        {
            $from=date("Y-m-d",strtotime(str_replace('/', '-', $request->from)));
        }else{
            $from='1901-01-01';
        }

        if($request->to)
        {
            $to=date("Y-m-d",strtotime(str_replace('/', '-', $request->to)));
        }else{
            $to=date("Y-m-d");
        }


        $data_update="policy_clients.data_update BETWEEN '".$from."' AND '".$to."'";





        $file_name='Report_bank_percent_'.$from.'_'.$to.".csv";

        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        header('Content-type: text/html; charset=cp1251');



        $percent=array();


        $data=$request->all();
        foreach($data as $key => $val ) {


            if (strncmp($key, "percent", 7) == 0) {
                $percent[] = $val;
            }
        }

        if(count($percent)==0)
        {
            for($i=0;$i<11;$i++) $percent[] = $i;
        }


        $data = DB::select('SELECT * FROM laravel.banks');



        $banks=array();
        foreach ($data as $key => $v){

            $banks[]=array("id" => $v->id, "name" => $v->name);
        }




        $csv=array();


        $csv[]= "Банк";
        foreach ($percent as $key => $val ) {
            if($val!=10) {
                $csv[]= ($val) * 5 . "% - " . (($val * 5) + 5)."%";
            }else{
                $csv[]=($val)*5 .'% - и более';
            }


        }
        $csv[] = "Итого";

        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');






        foreach ($banks as $key => $val ) {
            $csv=array();

            $csv[]= $val['name'];


            $temp_bank=0;
            foreach ($percent as $key => $per ) {


                $sql='';
                $sql= 'Select * From policy_clients WHERE ';
                $sql.= $data_update;
                $sql.=' AND (sum_strah/sum_kred)*100 >= '.($per * 5).' AND (sum_strah/sum_kred)*100 < '.(($per * 5) + 5);
                $sql.=' AND bankselect='.$val['id'];

                $data = DB::select($sql);

                $temp_bank=$temp_bank+count($data);
                $csv[]= count($data);


                $bigstat[$val['id']][$per]=count($data);
            }



            $csv[]=$temp_bank;

            array_walk($csv, array('self', 'encodeCSV'));
            fputcsv($fp, $csv,';');

        }





        $csv=array();
        $csv[]= "Итого";


        $summ_final=0;
        foreach ($percent as $key => $per ) {


            $temp_final=0;

            foreach ($banks as $key => $val ) {

                $temp_final=$temp_final+$bigstat[$val['id']][$per];



            }

            $csv[]= $temp_final;
            $summ_final=$summ_final+$temp_final;
        }

        $csv[]=$summ_final;

        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');




        fclose($fp);
        exit;


    }



    public function report_agent_call()
    {
        //

        return view('admin.report.report_agent_call');
    }

    public function report_agent_call_(Request $request)
    {

        $from = '';
        $to = '';

        if ($request->from) {
            $from = date("Y-m-d", strtotime(str_replace('/', '-', $request->from)));
        } else {
            $from = '1901-01-01';
        }

        if ($request->to) {
            $to = date("Y-m-d", strtotime(str_replace('/', '-', $request->to)));
        } else {
            $to = date("Y-m-d");
        }


        $date_update_calls = "calls.data_update BETWEEN '" . $from . "' AND '" . $to . "'";




        //time call

        if($request->timecall_from)
        {
            $timecall_from=$request->timecall_from;
        }else{
            $timecall_from=0;
        }

        if($request->timecall_to)
        {
            $timecall_to=$request->timecall_to;
        }else{
            $timecall_to=10000000;
        }

        $data = array();

        $user = array();

        $group = array();

        $response = '';


        $data = $request->all();


        foreach ($data as $key => $val) {


            if (strncmp($key, "reqs", 4) == 0) {
                $user[] = $val;
            }

            if (strncmp($key, "group", 5) == 0) {
                $group[] = $val;
            }

        }

        $data_second=array();

        $user_str='';
        foreach ($user as $v) {
            $user_str.="calls.id_agent='".$v."' OR ";
        }
        if(strlen($user_str)>0) $user_str=mb_substr($user_str, 0, -4);

        $group_str='';
        foreach ($group as $v) {
            $group_str.="policies.type_product='".$v."' OR ";
        }
        if(strlen($group_str)>0) $group_str=mb_substr($group_str, 0, -4);


        $sql="SELECT laravel.calls.*,
    laravel.policies.type_product
From
    laravel.calls LEFT Join
    laravel.clients On laravel.clients.id = laravel.calls.id_client LEFT Join
    laravel.policies On laravel.policies.id = laravel.calls.id_policy where ";
        $sql.=$date_update_calls;
        if(strlen($user_str)>0) $sql.=" AND (".$user_str.")";
        if(strlen($group_str)>0) $sql.=" AND (".$group_str.")";
        $sql.=" AND calls.uniqueid is not NULL";





        $data = DB::select($sql);


        $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
        $response .= "<tr><th>Дата</th><th>Оператор</th><th>Группа</th><th>Длительность</th></tr>";


        foreach ($data as $v) {


            $sql_aster="SELECT * FROM cdr where uniqueid='".$v->uniqueid."' and disposition='ANSWERED'";
            $data_second=DB::connection('mysql_second')->select($sql_aster);


            if(count($data_second)>0 ){

                if(intval($data_second[0]->billsec) > $timecall_from AND intval($data_second[0]->billsec) < $timecall_to)
                {
                    $response .= '<tr>';
                    $response .= '<td>' . date("h:i:s d/m/Y",strtotime($v->data_update)) . '</td>';
                    $response .= '<td>' . $v->id_agent . '</td>';
                    $response .= '<td>' . $v->type_product . '</td>';
                    $response .= '<td>' . $data_second[0]->billsec. '</td>';
                    $response .= '</tr>';
                }

            }



        }



        $response .= "</table>";


        $response.='<button name="create_excel" id="create_excel" class="btn btn-success">Сохранить файл</button>';



        return response()->json($response);



        //   dd(DB::connection('mysql_second')->select('Select * from cdr limit 10'));







    }


    public function report_agent_call_csv(Request $request)
    {

        $fp = fopen("php://output", "w");



        $from = '';
        $to = '';

        if ($request->from) {
            $from = date("Y-m-d", strtotime(str_replace('/', '-', $request->from)));
        } else {
            $from = '1901-01-01';
        }

        if ($request->to) {
            $to = date("Y-m-d", strtotime(str_replace('/', '-', $request->to)));
        } else {
            $to = date("Y-m-d");
        }


        $date_update_calls = "calls.data_update BETWEEN '" . $from . "' AND '" . $to . "'";


        $file_name='Report_agent_call_'.$from.'_'.$to.".csv";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        header('Content-type: text/html; charset=cp1251');

        //time call

        if($request->timecall_from)
        {
            $timecall_from=$request->timecall_from;
        }else{
            $timecall_from=0;
        }

        if($request->timecall_to)
        {
            $timecall_to=$request->timecall_to;
        }else{
            $timecall_to=10000000;
        }

        $data = array();

        $user = array();

        $group = array();

        $response = '';


        $data = $request->all();


        foreach ($data as $key => $val) {


            if (strncmp($key, "reqs", 4) == 0) {
                $user[] = $val;
            }

            if (strncmp($key, "group", 5) == 0) {
                $group[] = $val;
            }

        }


        $user_str='';
        foreach ($user as $v) {
            $user_str.="calls.id_agent='".$v."' OR ";
        }
        if(strlen($user_str)>0) $user_str=mb_substr($user_str, 0, -4);

        $group_str='';
        foreach ($group as $v) {
            $group_str.="policies.type_product='".$v."' OR ";
        }
        if(strlen($group_str)>0) $group_str=mb_substr($group_str, 0, -4);


        $sql="SELECT laravel.calls.*,
    laravel.policies.type_product
From
    laravel.calls LEFT Join
    laravel.clients On laravel.clients.id = laravel.calls.id_client LEFT Join
    laravel.policies On laravel.policies.id = laravel.calls.id_policy where ";
        $sql.=$date_update_calls;
        if(strlen($user_str)>0) $sql.=" AND (".$user_str.")";
        if(strlen($group_str)>0) $sql.=" AND (".$group_str.")";
        $sql.=" AND calls.uniqueid is not NULL";





        $data = DB::select($sql);

        $csv=array();


        $csv[]="Дата";
        $csv[]="Оператор";
        $csv[]="Группа";
        $csv[]="Длительность";

        array_walk($csv, array('self', 'encodeCSV'));
        fputcsv($fp, $csv,';');

        foreach ($data as $v) {


            $sql_aster="SELECT * FROM cdr where uniqueid='".$v->uniqueid."' and disposition='ANSWERED'";
            $data_second=DB::connection('mysql_second')->select($sql_aster);

            $csv=array();

            if(count($data_second)>0 ){

                if(intval($data_second[0]->billsec) > $timecall_from AND intval($data_second[0]->billsec) < $timecall_to)
                {

                    $csv[]=date("h:i:s d/m/Y",strtotime($v->data_update));
                    $csv[]=$v->id_agent;
                    $csv[]=$v->type_product;
                    $csv[]=$data_second[0]->billsec;

                    array_walk($csv, array('self', 'encodeCSV'));
                    fputcsv($fp, $csv,';');

                }

            }



        }



        fclose($fp);
        exit;




    }




    public function report_incorrect_(Request $request)
    {


        $from = '';
        $to = '';
        $from1 = '';
        $to1 = '';
        $response = '';


        if ($request->from) {
            $from = date("Y-m-d", strtotime(str_replace('/', '-', $request->from)));
        } else {
            $from = '1901-01-01';
        }

        if ($request->to) {
            $to = date("Y-m-d", strtotime(str_replace('/', '-', $request->to)));
        } else {
            $to = date("Y-m-d");
        }


        $data_policy = "policy_clients.data_policy BETWEEN '" . $from . "' AND '" . $to . "'";
        $data_policy_second= "second_databases.data_policy BETWEEN '" . $from . "' AND '" . $to . "'";




        if ($request->from1) {
            $from1 = date("Y-m-d", strtotime(str_replace('/', '-', $request->from1)));
        } else {
            $from1 = '1901-01-01';
        }

        if ($request->to1) {
            $to1 = date("Y-m-d", strtotime(str_replace('/', '-', $request->to1)));
        } else {
            $to1 = date("Y-m-d");
        }


        $data_update_call1 = "clients.data_update BETWEEN'" . $from1 . "' AND '" . $to1 . "'";
        $data_update_call2 = "policy_clients.data_update BETWEEN '" . $from1 . "' AND '" . $to1 . "'";






        /*
 Select
    laravel.clients.id,laravel.clients.fio,laravel.clients.data_rog,laravel.clients.data_update,policy_clients.policy_name,policy_clients.data_policy,
    policy_clients.data_update AS data_update_policy
From
    laravel.clients LEFT Join
    laravel.policy_clients On laravel.policy_clients.id_client = laravel.clients.id
    WHERE policy_clients.data_update BETWEEN '1901-01-01' AND '2020-06-11' OR clients.data_update BETWEEN '1901-01-01' AND '2020-06-25'
 */


        $sql='Select
    laravel.clients.id,laravel.clients.fio,laravel.clients.data_rog,laravel.clients.data_update,policy_clients.policy_name,policy_clients.data_policy,
    policy_clients.data_update AS data_update_policy,policy_clients.id AS policy_id
From
    laravel.clients LEFT Join
    laravel.policy_clients On laravel.policy_clients.id_client = laravel.clients.id
    WHERE ';
        $sql .=$data_policy;
        $sql .=" OR ".$data_update_call1;
        $sql .=" OR ".$data_update_call2;




        $data = DB::select($sql);

      //  dd($data);

        $response .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\">";
        $response .= "<tr><th>ФИО</th><th>ДР</th><th>Полис</th><th>ФИО-</th><th>ДР-</th><th>Полис-</th><th>Действие</th></tr>";


        foreach ($data as $v) {

            $sql_second='';
            $sql_second="SELECT * FROM laravel.second_databases where ";
            $sql_second.=$data_policy_second;
            if($request->type1) $sql_second.=" AND second_databases.fio='".$v->fio."'";
            if($request->type2) $sql_second.=" AND second_databases.fio='".$v->fio."' AND second_databases.data_rog='".$v->data_rog."'";
            if($request->type3) $sql_second.=" AND second_databases.policy_name='".$v->policy_name."'";



         //   dump($sql_second);

            $data_second=DB::select($sql_second);

            $response .= '<tr>';
            $response .= '<td>' . $v->fio . '</td>';
            $response .= '<td>' . date("d/m/Y",strtotime($v->data_rog)) . '</td>';
            $response .= '<td>' . $v->policy_name . '</td>';

          //  dump(count($data_second));
          $i=0;
            if (count($data_second) > 0) {

                foreach ($data_second as $second) {

                    $change=0;

                    if($i==0) {


                        if(strcmp($v->fio,$second->fio)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . $second->fio . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . $second->fio . '</td>';
                        }

                        if(strcmp($v->data_rog,$second->data_rog)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . date("d/m/Y", strtotime($second->data_rog)) . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . date("d/m/Y", strtotime($second->data_rog)) . '</td>';
                        }

                        if(strcmp($v->policy_name,$second->policy_name)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . $second->policy_name . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . $second->policy_name . '</td>';
                        }
                       if($change>0) {
                           $response .= '<td><button id="change" baseid="' . $v->id . '" policyid="' . $v->policy_id . '" secondid="' . $second->id . '" type="button">Изменить</button></td>';
                       }else{
                           $response .= '<td></td>';
                       }
                        $response .= '</tr>';
                    }else{

                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';

                        if(strcmp($v->fio,$second->fio)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . $second->fio . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . $second->fio . '</td>';
                        }

                        if(strcmp($v->data_rog,$second->data_rog)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . date("d/m/Y", strtotime($second->data_rog)) . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . date("d/m/Y", strtotime($second->data_rog)) . '</td>';
                        }

                        if(strcmp($v->policy_name,$second->policy_name)!=0) {
                            $response .= '<td bgcolor="#75B7DE">' . $second->policy_name . '</td>';
                            $change++;
                        }else {
                            $response .= '<td>' . $second->policy_name . '</td>';
                        }

                        if($change>0) {
                            $response .= '<td><button id="change" baseid="' . $v->id . '" policyid="' . $v->policy_id . '" secondid="' . $second->id . '" type="button">Изменить</button></td>';
                        }else{
                            $response .= '<td></td>';
                        }

                        $response .= '</tr>';
                    }
                    $i++;





                }

            }else{

                $response .= '<td></td>';
                $response .= '<td></td>';
                $response .= '<td></td>';
                $response .= '<td></td>';
                $response .= '</tr>';
            }


        }



        $response .= "</table>";

















      //  $response.='<button name="create_excel" id="create_excel" class="btn btn-success">Сохранить файл</button>';











        return response()->json($response);

    }





        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
