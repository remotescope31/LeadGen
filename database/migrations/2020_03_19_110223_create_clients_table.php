<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fio')->index();
            $table->date('data_rog')->index()->nullable();

            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('rodstvenniki')->nullable();

            $table->string('color1')->nullable();
            $table->string('color2')->nullable();

            $table->string('uniqueid')->nullable()->index();
            $table->integer('id_agent')->index();
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
        Schema::dropIfExists('clients');
    }
}
