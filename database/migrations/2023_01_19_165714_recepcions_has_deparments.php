<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecepcionsHasDeparments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions_has_deparments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recepcions_id');
            $table->unsignedBigInteger('deparments_id');
            $table->unsignedBigInteger('picture_id');
            $table->string('estatus_area')->default('no validado');
            $table->timestamps();

            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('deparments_id')->references('id')->on('deparments')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcions_has_deparments');
    }
}
