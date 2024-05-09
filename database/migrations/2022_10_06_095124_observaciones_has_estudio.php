<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ObservacionesHasEstudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones_has_estudios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('observaciones_id');
            $table->unsignedBigInteger('estudio_id');
            $table->unsignedBigInteger('recepcions_id');
            $table->timestamps();

            $table->foreign('observaciones_id')->references('id')->on('observaciones')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('estudio_id')->references('id')->on('estudios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones_has_estudios');
    }
}
