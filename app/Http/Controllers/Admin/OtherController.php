<?php

namespace App\Http\Controllers\Admin;

use App\Other;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class OtherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $others=Other::where('markread',false)->paginate(10);
        return view('admin.other.index',['others' => $others//Other::paginate(10)
        ]);
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
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function show(Other $other)
    {
        //


        return view('admin.other.show', ['other' => $other]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function edit(Other $other)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Other $other)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function destroy(Other $other,Request $request)
    {
        //


        if($request['otkat']==1){

            if($other->newfio!=null && $other->oldfio!=null && $other->newdatebirthd!=null && $other->olddatebirthd!=null)
            {
                //dd($other);

                $affected = DB::table('laravel.clients')->where('id',$other->id_client)->update(['fio' => $other->oldfio]);
                $affected = DB::table('laravel.clients')->where('id',$other->id_client)->update(['data_rog' => $other->olddatebirthd]);


            }

            if($other->newpolicy_name!=null && $other->oldpolicy_name!=null && $other->newdatepolicy!=null && $other->olddatepolicy!=null)
            {
                $affected = DB::table('laravel.policy_clients')->where('id',$other->id_policy)->update(['policy_name' => $other->oldpolicy_name]);
                $affected = DB::table('laravel.policy_clients')->where('id',$other->id_policy)->update(['data_policy' => $other->olddatepolicy]);
                //dd($other);

            }






        }




        $other->markread=true;
        $other->update();


        $others=Other::where('markread',false)->paginate(10);
        return view('admin.other.index',['others' => $others//Other::paginate(10)
        ]);

    }
}
