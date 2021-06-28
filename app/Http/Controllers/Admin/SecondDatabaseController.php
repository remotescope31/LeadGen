<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SecondDatabase;
use Illuminate\Http\Request;

class SecondDatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.baseasg.index');
    }
    public function importData(Request $request)
    {


        $data           =       array();

        $date_now = date(now());

        $first_name = "";
        $last_name = "";

        //  file validation
        $request->validate([
            "csv_file" => "required"
        ]);

        $file = $request->file("csv_file");
        $csvData = file_get_contents($file);

        //$rows = array_map("str_getcsv", explode("\n", $csvData));
        $rows = array_map(function($data) { return str_getcsv($data,";");}, explode("\n", $csvData));
        $header = array_shift($rows);
        /* 0 => "№ п/п"
  1 => "Номер полиса"
  2 => "Дата договора страхования"
  3 => "ФИО застрахованного"
  4 => "Дата рождения"
  5 => "Номер паспорта"
  6 => "Срок страхования (мес)"
  7 => "Мобильный телефон" */

        foreach ($rows as $row) {
            if (isset($row[0])) {
                if ($row[0] != "") {
                    // master lead data
                    $row = array_combine($header, $row);
                    $leadData = array(
                        "policy_name" => $row["Номер полиса"],
                        "data_policy" => date("Y-m-d",strtotime(str_replace('.', '-', $row["Дата договора страхования"]))),
                        "fio" => $row["ФИО застрахованного"],
                        "data_rog" => date("Y-m-d",strtotime(str_replace('.', '-', $row["Дата рождения"]))),
                        "passdata" => $row["Номер паспорта"],
                        "srok_dogov" => $row["Срок страхования (мес)"],
                        "number_phone" => $row["Мобильный телефон"],
                        "id_bank" => $request['bankselect'],
                        "data_update" => $date_now,
                    );



                    // ----------- check if lead already exists ----------------
                    //
                    $checkLead        =       SecondDatabase::where("policy_name", "=", $row["Номер полиса"])->where("fio", "=", $row["ФИО застрахованного"])->where("data_rog", "=", date("Y-m-d",strtotime(str_replace('.', '-', $row["Дата рождения"]))))->first();


                    if (!is_null($checkLead)) {
                       // $updateLead   =       SecondDatabase::where("email", "=", $row["email"])->update($leadData);
                        //if($updateLead == true) {
                            $data["status"]     =       "failed";
                            $data["message"]    =       "Leads updated successfully";
                        //}
                    }

                    else {
                        $lead = SecondDatabase::create($leadData);
                        if(!is_null($lead)) {
                            $data["status"]     =       "success";
                            $data["message"]    =       "Leads imported successfully";
                        }
                    }
                }
            }
        }

        return back()->with($data["status"], $data["message"]);

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
     * @param  \App\SecondDatabase  $secondDatabase
     * @return \Illuminate\Http\Response
     */
    public function show(SecondDatabase $secondDatabase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SecondDatabase  $secondDatabase
     * @return \Illuminate\Http\Response
     */
    public function edit(SecondDatabase $secondDatabase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SecondDatabase  $secondDatabase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecondDatabase $secondDatabase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SecondDatabase  $secondDatabase
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecondDatabase $secondDatabase)
    {
        //
    }
}
