<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColor1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color1s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('color1')->unique();
            $table->string('description',2048)->nullable();
            $table->string('description1',2048)->nullable();
            $table->string('description2',2048)->nullable();


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
        Schema::dropIfExists('color1s');
    }
}
