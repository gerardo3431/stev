<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Analitos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analitos', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->string('descripcion');
            $table->string('bitacora')->nullable();
            $table->string('defecto')->nullable();
            $table->string('unidad')->nullable();
            $table->string('digito')->nullable();
            $table->string('tipo_resultado')->nullable();

            $table->text('valor_referencia')->nullable();
            $table->text('tipo_referencia')->nullable();
            $table->string('tipo_validacion')->nullable();

            $table->string('numero_uno')->nullable();
            $table->string('numero_dos')->nullable();

            $table->text('documento')->nullable();
            // $table->string('valor_referencia')->nullable();
            $table->string('imagen')->nullable();
            $table->string('valida_qr')->nullable();

            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analitos');
    }
}
