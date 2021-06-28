<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyClientChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_client_changes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_policy')->index();
            $table->bigInteger('id_client')->index();
            $table->string('policy_name')->index();
            $table->date('data_policy')->index()->nullable();

            $table->string('bank')->nullable();
            $table->string('prod_name',2048)->nullable();

            $table->integer('bankselect')->nullable();
            $table->integer('policyselect')->nullable();

            $table->string('riski',2048)->nullable();
            $table->string('vid_kred',2048)->nullable();
            $table->string('strah_vipl',2048)->nullable();
            $table->decimal('sum_kred',15,2)->nullable();
            $table->decimal('sum_strah',15,2)->nullable();
            $table->integer('srok_dogov')->nullable();

            $table->string('otkaz')->nullable();
            $table->string('reshenie')->nullable();
            $table->string('udergal')->nullable();

            $table->string('comment1')->nullable();
            $table->string('comment2')->nullable();

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
        Schema::dropIfExists('policy_client_changes');
    }
}
