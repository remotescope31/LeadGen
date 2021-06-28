<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_client')->nullable();
            $table->bigInteger('id_policy')->nullable();

            $table->string('newfio')->nullable();
            $table->string('oldfio')->nullable();
            $table->date('newdatebirthd')->nullable();
            $table->date('olddatebirthd')->nullable();



            $table->string('newpolicy_name')->nullable();
            $table->string('oldpolicy_name')->nullable();
            $table->date('newdatepolicy')->nullable();
            $table->date('olddatepolicy')->nullable();

            $table->string('uniqueid')->nullable()->index();
            $table->bigInteger('id_agent')->nullable();
            $table->datetime('dateupdate')->nullable();

            $table->boolean('markread')->default(false)->index();
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
        Schema::dropIfExists('others');
    }
}
