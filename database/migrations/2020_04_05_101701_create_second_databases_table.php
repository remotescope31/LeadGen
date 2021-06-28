<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('second_databases', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('policy_name')->index();
            $table->date('data_policy')->index()->nullable();

            $table->string('fio')->index();
            $table->date('data_rog')->index();

            $table->string('passdata',2048)->nullable();
            $table->date('data_begin_policy')->index()->nullable();

            $table->integer('srok_dogov')->nullable();
            $table->string('number_phone')->index();


            $table->integer('id_bank')->index();
            $table->dateTime('data_update')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('second_databases');
    }
}
