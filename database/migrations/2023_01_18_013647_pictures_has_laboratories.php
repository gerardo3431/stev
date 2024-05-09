<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PicturesHasLaboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures_has_laboratories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('picture_id');
            $table->unsignedBigInteger('laboratory_id');
            $table->timestamps();

            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('laboratory_id')->references('id')->on('laboratories')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pictures_has_laboratories');
    }
}
