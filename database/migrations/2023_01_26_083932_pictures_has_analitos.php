<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PicturesHasAnalitos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures_has_analitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('picture_id');
            $table->unsignedBigInteger('analito_id'); 
            $table->integer('orden')->nullable();
            $table->timestamps();
            
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('analito_id')->references('id')->on('analitos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures_has_analitos');
    }
}
