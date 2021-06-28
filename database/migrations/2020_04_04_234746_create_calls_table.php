<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('database')->nullable();

            $table->bigInteger('id_policy')->index()->nullable();
            $table->bigInteger('id_client')->index();
            $table->string('uniqueid')->nullable();

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
        Schema::dropIfExists('calls');
    }
}
