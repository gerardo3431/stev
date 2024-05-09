<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrefoliosHasEstudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefolios_has_listas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prefolio_id');
            $table->unsignedBigInteger('lista_id');
            $table->timestamps();

            $table->foreign('prefolio_id')->references('id')->on('prefolios')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('prefolios_has_listas');
    }
}
