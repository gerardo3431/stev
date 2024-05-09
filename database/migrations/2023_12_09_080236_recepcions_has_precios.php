<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecepcionsHasPrecios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions_has_precios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recepcions_id');
            // $table->unsignedBigInteger('precio_id');
            $table->unsignedBigInteger('lista_id');
            $table->timestamps();

            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('precio_id')->references('id')->on('precios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('lista_id')->references('id')->on('listas')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcions_has_precios');
    }
}
