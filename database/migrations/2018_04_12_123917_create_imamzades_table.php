<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImamzadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imamzades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imamzade_Name' , 100);
            $table->string('Ancestor',50);
            $table->string('Address',200);
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('PID');
            $table->integer('CID');
            $table->integer('UID');
            $table->timestamps();
            $table->foreign('PID')->references('id')->on('provinces');
            $table->foreign('CID')->references('id')->on('cities');
            $table->foreign('UID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imamzades');
    }
}
