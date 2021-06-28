<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    //
    protected $fillable = [
        'bank_id','name_policy', 'regex_policy','type_product',
    ];

}
