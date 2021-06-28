<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Client;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        return view('client.index');
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



        $id_agent=Auth::user()->id;

        $date_now=date(now());


        //$fio=$request->fio;
        $fio=preg_replace("/  +/"," ",$request->fio);

        $datebirthd=$request->datebirthd;
        if(isset($datebirthd)) {
            $datebirthd = date("Y-m-d", strtotime(str_replace('/', '-', $datebirthd)));
        }else{
            $datebirthd='1901-01-01';
        }
        $color1=$request->color1;
        $color2=$request->color2;

        $numberpolicy=$request->numberpolicy;
        $bankselect=$request->bankselect;
        $policyselect=$request->policyselect;

        $datepolicy=$request->datepolicy;
        if(isset($datepolicy)) {
        $datepolicy=date("Y-m-d",strtotime(str_replace('/', '-', $datepolicy)));
        }else{
            $datepolicy='1901-01-01';
        }
       // dd($datepolicy);
        $numberphone=$request->numberphone;
        $addphone=$request->addphone;
        $summstrah=$request->summstrah;
        if($summstrah) $summstrah=preg_replace("/,/",".",$summstrah);
        $summkred=$request->summkred;
        if($summkred) $summkred=preg_replace("/,/",".",$summkred);
        $srokdogov=$request->srokdogov;
        $region=$request->region;
        $city=$request->city;
        $comment1=$request->comment1;
        $comment2=$request->comment2;
        $rodstvenniki=$request->rodstvenniki;
        $reshenie=$request->reshenie;
        $udergal=$request-> udergal;
        $otkaz =$request->otkaz;

        $id_client=$request->id_client;
        $id_database=$request->id_database;
        $id_policy=$request->id_policy;

        $uniqueid=$request->uniqueid;


        if(!isset($id_database))
        {
            $id_database=0;
        }

        if($id_database==2) {
            unset($id_client);
            unset($id_policy);
        }




    if(isset($id_client))
    {//упдейтим имеющуюся запись перед этим должны сохранить в change (доделаем)

        $data_client=DB::select('SELECT * FROM laravel.clients where id=?',[$id_client]);
        foreach ($data_client as $key => $v) {
            $data_client_id=$v->id;
            $data_client_fio=$v->fio;
            $data_client_data_rog=$v->data_rog;
            $data_client_region=$v->region;
            $data_client_city=$v->city;
            $data_client_rodstvenniki=$v->rodstvenniki;
            $data_client_color1=$v->color1;
            $data_client_color2=$v->color1;
            $data_client_id_agent=$v->id_agent;
            $data_client_data_update=$v->data_update;
            $data_client_uniqueid=$v->uniqueid;
        }
        DB::table('laravel.client_changes')->insertGetId(
            ['id_client'=>$data_client_id,'fio' => $data_client_fio,'data_rog'=>$data_client_data_rog,
                'region'=>$data_client_region,'city'=>$data_client_city,'rodstvenniki'=>$data_client_rodstvenniki,'color1'=>$data_client_color1,'color2'=>$data_client_color2,'uniqueid'=>$data_client_uniqueid,
                'id_agent'=>$data_client_id_agent,'data_update'=>$data_client_data_update]);

///////////////////////////////////
///вставка изменений клиента
 if($data_client_fio!=$fio || $data_client_data_rog!=$datebirthd)
 {
     DB::table('laravel.others')->insertGetId(
         ['id_client'=>$id_client,'id_policy'=>$id_policy,'newfio' => $fio,'oldfio' => $data_client_fio,'newdatebirthd'=>$datebirthd,'olddatebirthd'=>$data_client_data_rog,
             'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'dateupdate'=>$date_now]);

 }
//////////////////////////////////

        $affected = DB::table('laravel.clients')
            ->where('id', $id_client)
            ->update(['fio' => $fio,'data_rog'=>$datebirthd,'region'=>$region,'city'=>$city,'rodstvenniki'=>$rodstvenniki,'color1'=>$color1,'color2'=>$color2,'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'data_update'=>$date_now]);


    }else{
     //вносим в базу нового пользователя

        $data=DB::select('SELECT * FROM laravel.clients where fio=? AND data_rog=?',[$fio,$datebirthd]);

       // dd($data);

        if(count($data)==0){

            $id_client = DB::table('laravel.clients')->insertGetId(
                ['fio' => $fio,'data_rog'=>$datebirthd,'region'=>$region,'city'=>$city,'rodstvenniki'=>$rodstvenniki,'color1'=>$color1,'color2'=>$color2,'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'data_update'=>$date_now]);

        }else{

            foreach ($data as $key => $v) {
                $id_client=$v->id;

            }


            $data_client=DB::select('SELECT * FROM laravel.clients where id=?',[$id_client]);
            foreach ($data_client as $key => $v) {
                $data_client_id=$v->id;
                $data_client_fio=$v->fio;
                $data_client_data_rog=$v->data_rog;
                $data_client_region=$v->region;
                $data_client_city=$v->city;
                $data_client_rodstvenniki=$v->rodstvenniki;
                $data_client_color1=$v->color1;
                $data_client_color2=$v->color1;
                $data_client_id_agent=$v->id_agent;
                $data_client_data_update=$v->data_update;
                $data_client_uniqueid=$v->uniqueid;
            }
            DB::table('laravel.client_changes')->insertGetId(
                ['id_client'=>$data_client_id,'fio' => $data_client_fio,'data_rog'=>$data_client_data_rog,
                    'region'=>$data_client_region,'city'=>$data_client_city,'rodstvenniki'=>$data_client_rodstvenniki,'color1'=>$data_client_color1,'color2'=>$data_client_color2,'uniqueid'=>$data_client_uniqueid,
                    'id_agent'=>$data_client_id_agent,'data_update'=>$data_client_data_update]);


///////////////////////////////////
///вставка изменений клиента
            if($data_client_fio!=$fio || $data_client_data_rog!=$datebirthd)
            {
                DB::table('laravel.others')->insertGetId(
                    ['id_client'=>$id_client,'id_policy'=>$id_policy,'newfio' => $fio,'oldfio' => $data_client_fio,'newdatebirthd'=>$datebirthd,'olddatebirthd'=>$data_client_data_rog,
                        'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'dateupdate'=>$date_now]);

            }
//////////////////////////////////

            $affected = DB::table('laravel.clients')
                ->where('id', $id_client)
                ->update(['fio' => $fio,'data_rog'=>$datebirthd,'region'=>$region,'city'=>$city,'rodstvenniki'=>$rodstvenniki,'color1'=>$color1,'color2'=>$color2,'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'data_update'=>$date_now]);





        }




    }



    //////////////////////////////////
        /// телефоны
        ///
        if(isset($addphone))
        {
            //dump($addphone);
            $data=DB::select('SELECT * FROM laravel.phones where phone=? AND id_client=?',[$addphone,$id_client]);
            //dump($data);
            if (count($data) == 0)
            {
               // dd('fuck');
                //нет добавляем
                $phone = new Phone();
                $phone->id_client=$id_client;
                $phone->id_agent=$id_agent;
                $phone->phone=$addphone;
                $phone->data_update=$date_now;
                $phone->save();

            }else{

                //есть ничего не делаем

            }


        }



        $numberphone_res = explode(",", $numberphone);

        //dd($numberphone_res);

        $data=DB::select('DELETE FROM laravel.phones WHERE id_client=?',[$id_client]);

        foreach ($numberphone_res as $v) {
//dump($v);
            $data=DB::select('SELECT * FROM laravel.phones where phone=? AND id_client=?',[trim($v),$id_client]);
          //  dump($data);
            if (count($data) == 0)
            {//
             //   dump($v);
              //  dd($numberphone_res);
                //нет добавляем

                if(strlen($v)>0) {
                    $phone = new Phone();
                    $phone->id_client = $id_client;
                    $phone->id_agent = $id_agent;
                    $phone->phone = trim($v);
                    $phone->data_update = $date_now;
                    $phone->save();
                }
            }else{

                //есть ничего не делаем

            }



        }



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////






        //получение названия банка
        $data=DB::select('SELECT * FROM laravel.banks where id=? limit 1',[$bankselect]);
        if (count($data) == 0)
        {
            //банк не выбран
            $bankname = NULL;
            $bankphone = NULL;
        }else{

            foreach ($data as $key => $v) {
                $bankname = $v->name;
                $bankphone = $v->phone;
            }


        }


        //получение названия продукта и тд.....
        $data=DB::select('SELECT * FROM laravel.products where id=? limit 1',[$policyselect]);
        //dump($data);
        if (count($data) == 0)
        {
            //продукт не выбран
            $name_product=NULL;
            $riski=NULL;
            $vid_kred=NULL;
            $poter_rab=NULL;
            $strah_vipl=NULL;

        }else{

            foreach ($data as $key => $v) {
                $name_product=$v->name_product;
                $riski=$v->riski;
                $vid_kred=$v->vid_kred;
                $poter_rab=$v->poter_rab;
                $strah_vipl=$v->strah_vipl;
            }


        }



        if(isset($numberpolicy)) {

            if (isset($id_policy)) {
                //упдейтим имеющуюся запись полиса перед этим должны сохранить в change (доделаем)

                $data_policy_client = DB::select('SELECT * FROM laravel.policy_clients where id=?', [$id_policy]);
                foreach ($data_policy_client as $key => $v) {
                    $data_policy_client_id = $v->id;
                    $data_policy_client_id_client = $v->id_client;
                    $data_policy_client_policy_name = $v->policy_name;
                    $data_policy_client_data_policy = $v->data_policy;
                    $data_policy_client_bank = $v->bank;
                    $data_policy_client_prod_name = $v->prod_name;
                    $data_policy_client_bank_select = $v->bankselect;
                    $data_policy_client_policyselect = $v->policyselect;
                    $data_policy_client_riski = $v->riski;
                    $data_policy_client_vid_kred = $v->vid_kred;
                    $data_policy_client_strah_vipl = $v->strah_vipl;
                    $data_policy_client_summ_kred = $v->sum_kred;
                    $data_policy_client_summ_strah = $v->sum_strah;
                    $data_policy_client_srok_dogov = $v->srok_dogov;
                    $data_policy_client_otkaz = $v->otkaz;
                    $data_policy_client_reshenie = $v->reshenie;
                    $data_policy_client_strah_udergal = $v->udergal;
                    $data_policy_client_comment1 = $v->comment1;
                    $data_policy_client_comment2 = $v->comment2;
                    $data_policy_client_id_agent = $v->id_agent;
                    $data_policy_client_data_update = $v->data_update;
                    $data_policy_client_uniqueid = $v->uniqueid;
                }

                DB::table('laravel.policy_client_changes')
                    ->insertGetId(['id_policy' => $data_policy_client_id, 'id_client' => $data_policy_client_id_client, 'policy_name' => $data_policy_client_policy_name, 'data_policy' => $data_policy_client_data_policy,
                        'bank' => $data_policy_client_bank, 'prod_name' => $data_policy_client_prod_name, 'bankselect' => $data_policy_client_bank_select,
                        'policyselect' => $data_policy_client_policyselect, 'riski' => $data_policy_client_riski, 'vid_kred' => $data_policy_client_vid_kred, 'strah_vipl' => $data_policy_client_strah_vipl,
                        'sum_kred' => $data_policy_client_summ_kred, 'sum_strah' => $data_policy_client_summ_strah, 'srok_dogov' => $data_policy_client_srok_dogov,
                        'otkaz' => $data_policy_client_otkaz, 'reshenie' => $data_policy_client_reshenie, 'udergal' => $data_policy_client_strah_udergal,
                        'comment1' => $data_policy_client_comment1, 'comment2' => $data_policy_client_comment2,'uniqueid'=>$data_policy_client_uniqueid ,'id_agent' => $data_policy_client_id_agent, 'data_update' => $data_policy_client_data_update]);



                ///////////////////////////////////
///вставка изменений клиента
                if($numberpolicy!=$data_policy_client_policy_name || $data_policy_client_data_policy!=$datepolicy)
                {
                    DB::table('laravel.others')->insertGetId(
                        ['id_client'=>$id_client,'id_policy'=>$id_policy,'newpolicy_name' => $numberpolicy,'oldpolicy_name' => $data_policy_client_policy_name,
                            'newdatepolicy'=>$datepolicy,'olddatepolicy'=>$data_policy_client_data_policy,
                            'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'dateupdate'=>$date_now]);

                }
//////////////////////////////////






                $affected = DB::table('laravel.policy_clients')
                    ->where('id', $id_policy)
                    ->update(['id_client' => $id_client, 'policy_name' => $numberpolicy, 'data_policy' => $datepolicy, 'bank' => $bankname, 'prod_name' => $name_product, 'bankselect' => $bankselect, 'policyselect' => $policyselect,
                        'riski' => $riski, 'vid_kred' => $vid_kred, 'strah_vipl' => $strah_vipl, 'sum_kred' => $summkred, 'sum_strah' => $summstrah, 'srok_dogov' => $srokdogov, 'otkaz' => $otkaz,
                        'reshenie' => $reshenie, 'udergal' => $udergal, 'comment1' => $comment1, 'comment2' => $comment2, 'uniqueid'=>$uniqueid,'id_agent' => $id_agent, 'data_update' => $date_now]);


            } else {

                $data = DB::select('SELECT * FROM laravel.policy_clients where policy_name=? AND id_client=?', [$numberpolicy, $id_client]);


                if (count($data) == 0) {

                    $id_policy = DB::table('laravel.policy_clients')
                        ->insertGetId(['id_client' => $id_client, 'policy_name' => $numberpolicy, 'data_policy' => $datepolicy, 'bank' => $bankname, 'prod_name' => $name_product, 'bankselect' => $bankselect, 'policyselect' => $policyselect,
                            'riski' => $riski, 'vid_kred' => $vid_kred, 'strah_vipl' => $strah_vipl, 'sum_kred' => $summkred, 'sum_strah' => $summstrah, 'srok_dogov' => $srokdogov, 'otkaz' => $otkaz,
                            'reshenie' => $reshenie, 'udergal' => $udergal, 'comment1' => $comment1, 'comment2' => $comment2,'uniqueid'=>$uniqueid ,'id_agent' => $id_agent, 'data_update' => $date_now]);
                } else {

                    foreach ($data as $key => $v) {
                        $id_policy = $v->id;

                    }


                    $data_policy_client = DB::select('SELECT * FROM laravel.policy_clients where id=?', [$id_policy]);
                    foreach ($data_policy_client as $key => $v) {
                        $data_policy_client_id = $v->id;
                        $data_policy_client_id_client = $v->id_client;
                        $data_policy_client_policy_name = $v->policy_name;
                        $data_policy_client_data_policy = $v->data_policy;
                        $data_policy_client_bank = $v->bank;
                        $data_policy_client_prod_name = $v->prod_name;
                        $data_policy_client_bank_select = $v->bankselect;
                        $data_policy_client_policyselect = $v->policyselect;
                        $data_policy_client_riski = $v->riski;
                        $data_policy_client_vid_kred = $v->vid_kred;
                        $data_policy_client_strah_vipl = $v->strah_vipl;
                        $data_policy_client_summ_kred = $v->sum_kred;
                        $data_policy_client_summ_strah = $v->sum_strah;
                        $data_policy_client_srok_dogov = $v->srok_dogov;
                        $data_policy_client_otkaz = $v->otkaz;
                        $data_policy_client_reshenie = $v->reshenie;
                        $data_policy_client_strah_udergal = $v->udergal;
                        $data_policy_client_comment1 = $v->comment1;
                        $data_policy_client_comment2 = $v->comment2;
                        $data_policy_client_id_agent = $v->id_agent;
                        $data_policy_client_data_update = $v->data_update;
                        $data_policy_client_uniqueid = $v->uniqueid;
                    }

                    DB::table('laravel.policy_client_changes')
                        ->insertGetId(['id_policy' => $data_policy_client_id, 'id_client' => $data_policy_client_id_client, 'policy_name' => $data_policy_client_policy_name, 'data_policy' => $data_policy_client_data_policy,
                            'bank' => $data_policy_client_bank, 'prod_name' => $data_policy_client_prod_name, 'bankselect' => $data_policy_client_bank_select,
                            'policyselect' => $data_policy_client_policyselect, 'riski' => $data_policy_client_riski, 'vid_kred' => $data_policy_client_vid_kred, 'strah_vipl' => $data_policy_client_strah_vipl,
                            'sum_kred' => $data_policy_client_summ_kred, 'sum_strah' => $data_policy_client_summ_strah, 'srok_dogov' => $data_policy_client_srok_dogov,
                            'otkaz' => $data_policy_client_otkaz, 'reshenie' => $data_policy_client_reshenie, 'udergal' => $data_policy_client_strah_udergal,
                            'comment1' => $data_policy_client_comment1, 'comment2' => $data_policy_client_comment2,'uniqueid'=>$data_policy_client_uniqueid ,'id_agent' => $data_policy_client_id_agent, 'data_update' => $data_policy_client_data_update]);

///вставка изменений клиента
                    if($numberpolicy!=$data_policy_client_policy_name || $data_policy_client_data_policy!=$datepolicy)
                    {
                        DB::table('laravel.others')->insertGetId(
                            ['id_client'=>$id_client,'id_policy'=>$id_policy,'newpolicy_name' => $numberpolicy,'oldpolicy_name' => $data_policy_client_policy_name,
                                'newdatepolicy'=>$datepolicy,'olddatepolicy'=>$data_policy_client_data_policy,
                                'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'dateupdate'=>$date_now]);

                    }
//////////////////////////////////
///
                    $affected = DB::table('laravel.policy_clients')
                        ->where('id', $id_policy)
                        ->update(['id_client' => $id_client, 'policy_name' => $numberpolicy, 'data_policy' => $datepolicy, 'bank' => $bankname, 'prod_name' => $name_product, 'bankselect' => $bankselect, 'policyselect' => $policyselect,
                            'riski' => $riski, 'vid_kred' => $vid_kred, 'strah_vipl' => $strah_vipl, 'sum_kred' => $summkred, 'sum_strah' => $summstrah, 'srok_dogov' => $srokdogov, 'otkaz' => $otkaz,
                            'reshenie' => $reshenie, 'udergal' => $udergal, 'comment1' => $comment1, 'comment2' => $comment2, 'uniqueid'=>$uniqueid,'id_agent' => $id_agent, 'data_update' => $date_now]);


                }


            }

        }






//вставка в калл
        //$uniqueid=NULL;
        $id_policy = DB::table('laravel.calls')
            ->insertGetId(['database'=>$id_database,'id_policy'=>$id_policy,'id_client'=> $id_client,'uniqueid'=>$uniqueid,'id_agent'=>$id_agent,'data_update'=>$date_now]);



       return redirect()->route('client.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
