<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoryMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('article_id');

            $table->enum('tipo_movimiento', ['entrada', 'salida']);
            $table->dateTime('fecha_movimiento');
            $table->integer('cantidad_movida');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
}
