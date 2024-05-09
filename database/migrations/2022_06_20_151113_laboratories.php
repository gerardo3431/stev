<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Laboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('razon_social');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('pais');
            $table->string('cp');
            $table->string('email')->nullable();
            $table->string('telefono');
            $table->string('rfc')->nullable();
            $table->string('logotipo');
            $table->string('membrete')->nullable();
            $table->string('membrete_secundario')->nullable();
            $table->string('membrete_terciario')->nullable();
            $table->string('membrete_img')->nullable();
            $table->string('responsable_sanitario')->default('Jhonny Joestar');
            $table->string('cedula_sanitario')->default('132456');
            $table->string('firma_sanitario')->default('nd');
            $table->string('responsable_img')->default('Jhonny Joestar');
            $table->string('cedula_img')->default('132456');
            $table->string('firma_img')->default('nd');
            $table->boolean('inventario_inicial');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratories');
    }
}
