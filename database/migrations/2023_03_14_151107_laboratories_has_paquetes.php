<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaboratoriesHasPaquetes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratories_has_paquetes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paquetes_id');
            $table->unsignedBigInteger('laboratory_id');
            $table->timestamps();

            $table->foreign('paquetes_id')->references('id')->on('paquetes')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('laboratories_has_paquetes');
    }
}
