<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_polls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('id_agent')->index();
            $table->string('tonumber')->index();
            $table->string('textsms',1024);
            $table->string('id_sms')->index();
            $table->integer("templatesms");
            $table->dateTime('timesms')->index();

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
        Schema::dropIfExists('sms_polls');
    }
}
