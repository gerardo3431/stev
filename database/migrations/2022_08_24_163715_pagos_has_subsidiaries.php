<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagosHasSubsidiaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_has_subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pago_id');
            $table->unsignedBigInteger('subsidiary_id');
            $table->timestamps();

            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subsidiary_id')->references('id')->on('subsidiaries')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_has_subsidiaries');
    }
}
