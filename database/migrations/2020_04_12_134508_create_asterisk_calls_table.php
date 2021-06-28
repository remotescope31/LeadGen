<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsteriskCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asterisk_calls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('fromnumber')->nullable()->index();
            $table->string('tonumber')->nullable()->index();
            $table->string('uniqueid')->nullable()->index();
            $table->boolean('enabled')->nullable()->default(true);
            $table->dateTime('calldate')->nullable()->index();

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
        Schema::dropIfExists('asterisk_calls');
    }
}
