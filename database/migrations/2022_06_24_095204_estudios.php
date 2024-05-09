<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Estudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->string('codigo')->nullable();
            $table->text('descripcion');
            $table->text('condiciones')->nullable();
            $table->text('aplicaciones')->nullable();
            $table->integer('dias_proceso')->nullable();
            $table->integer('precio')->nullable();
            $table->integer('valida_qr')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudios');
    }
}
