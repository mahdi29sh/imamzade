<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_images', function (Blueprint $table) {
            $table->increments('temp_img_id');
            $table->integer('TIID');
            $table->string('image');
            $table->boolean('is_first');
            $table->timestamps();
            $table->foreign('TIID')->references('id')->on('imamzade_temps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_images');
    }
}
