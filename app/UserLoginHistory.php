<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use DB;

class UserLoginHistory extends Model
{
public $timestamps = false;

    protected $table = 'user_login_history';

    protected $fillable = ['user_id','login_at','logout_at','login_ip','session_id'];


    public function setLogOutLog(){

        DB::table('user_login_history')->  where('session_id',session('user_login'))->update([
            'logout_at' =>Carbon::now(),
        ]);

    }

    public function setLogInLog(){




        session(['user_login' => request()->session()->getId()]);

        DB::table('user_login_history')->insert(
            ['user_id' => Auth::user()->id,'login_at' =>Carbon::now(),
                'login_ip'=>request()->getClientIp(),'session_id'=>session('user_login')
            ]);


    }




}
