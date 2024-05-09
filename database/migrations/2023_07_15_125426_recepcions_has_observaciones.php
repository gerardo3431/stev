<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecepcionsHasObservaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions_has_observaciones', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('recepcions_id');
            $table->unsignedBigInteger('observaciones_id');

            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('observaciones_id')->references('id')->on('observaciones')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcions_has_observaciones');

    }
}
