<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cajas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();

            $table->string('apertura')->nullable()->default(0);
            $table->string('entradas')->nullable()->default(0);
            $table->string('salidas')->nullable()->default(0);
            $table->string('ventas_efectivo')->nullable()->default(0);
            $table->string('ventas_tarjeta')->nullable()->default(0);
            $table->string('ventas_transferencia')->nullable()->default(0);
            $table->string('salidas_efectivo')->nullable()->default(0);
            $table->string('salidas_tarjeta')->nullable()->default(0);
            $table->string('salidas_transferencia')->nullable()->default(0);
            $table->string('retiros')->nullable()->default(0);
            $table->string('total')->nullable()->default(0);
            $table->string('estatus')->nullable();
            
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cajas');
    }
}
