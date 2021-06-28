<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_changes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_phone')->index();
            $table->bigInteger('id_client')->index();
            $table->string('phone')->index();

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
        Schema::dropIfExists('phone_changes');
    }
}
