<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecepcionsHasAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions_has_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recepcions_id');
            $table->unsignedBigInteger('area_id');
            $table->string('estatus_area')->default('solicitado');
            $table->timestamps();
            
            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcions_has_areas');
    }
}