<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagosHasCajas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_has_cajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_id');
            $table->unsignedBigInteger('pago_id');
            
            $table->timestamps();

            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_has_cajas');
    }
}
