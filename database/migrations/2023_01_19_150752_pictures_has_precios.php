<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PicturesHasPrecios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures_has_precios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('picture_id');
            $table->unsignedBigInteger('precio_id');
            $table->timestamps();

            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('precio_id')->references('id')->on('precios')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures_has_precios');
    }
}
