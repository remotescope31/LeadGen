<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondDatabase extends Model
{
    protected $fillable = [
        "policy_name",
        "data_policy",
        "fio",
        "data_rog",
        "passdata",
        "srok_dogov",
        "number_phone",
        "id_bank",
        "data_update"
    ];





/*
$table->string('policy_name')->index();
$table->date('data_policy')->index()->nullable();

$table->string('fio')->index();
$table->string('data_rog')->index();

$table->string('passdata',2048)->nullable();
$table->date('data_begin_policy')->index()->nullable();

$table->integer('srok_dogov')->nullable();
$table->string('number_phone')->index();


$table->integer('id_bank')->index();
$table->dateTime('data_update')->index();
*/
}
