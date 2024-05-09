<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmpresasHasPrecios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_has_precios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresas_id');
            $table->unsignedBigInteger('precio_id');
            $table->timestamps();
        
            $table->foreign('empresas_id')->references('id')->on('empresas')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('empresas_has_precios');
    }
}
