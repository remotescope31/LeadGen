<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    //
    protected $fillable = [
        'id_client', 'id_policy','newfio','oldfio','newdatebirthd','olddatebirthd','newpolicy_name','oldpolicy_name','newdatepolicy','olddatepolicy','dateupdate','markread'
    ];
}
