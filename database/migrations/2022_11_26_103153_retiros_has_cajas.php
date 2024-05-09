<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RetirosHasCajas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiros_has_cajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retiro_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caja_id');
            $table->timestamps();

            $table->foreign('retiro_id')->references('id')->on('retiros')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiros_has_cajas');
    }
}
