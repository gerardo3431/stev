<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FormulasHasEstudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulas_has_estudios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudio_id');
            $table->unsignedBigInteger('formulas_id');
            $table->timestamps();

            $table->foreign('estudio_id')->references('id')->on('estudios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('formulas_id')->references('id')->on('formulas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulas_has_estudios');
    }
}
