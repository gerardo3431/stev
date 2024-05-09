<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Historials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historials', function (Blueprint $table) {
            $table->id();
            // $table->string('historial_id');
            $table->string('clave');
            $table->string('descripcion');
            $table->text('valor')->nullable();
            $table->boolean('absoluto');
            $table->text('valor_abs')->nullable();
            $table->string('estatus')->default('invalidado');
            $table->string('entrega')->default('no entregado');
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
        Schema::dropIfExists('historials');
    }
}
