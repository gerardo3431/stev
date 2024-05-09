<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagosHasRecepcions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_has_recepcions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pago_id');
            $table->unsignedBigInteger('recepcions_id');
            $table->timestamps();

            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_has_recepcions');
    }
}
