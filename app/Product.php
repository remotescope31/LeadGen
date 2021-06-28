<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'policy_id','name_product', 'riski', 'vid_kred','poter_rab','strah_vipl',
    ];

}
