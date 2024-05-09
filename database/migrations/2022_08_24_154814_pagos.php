<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // protected $fillable = [
    //     'observaciones','importe','descripcion','clinica_id','doctor_id','paciente_id','consulta_id','tipo_movimiento','metodo_pago','caja_id','cerrado','razon_social','rfc','domicilio','email','is_factura'
    // ];
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->string('descripcion')->nullable();
            $table->string('importe');
            $table->string('tipo_movimiento')->default('ingreso');
            $table->string('metodo_pago');
            $table->string('observaciones')->nullable();
            
            $table->string('is_factura')->default('no');
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('email')->nullable();
            
            $table->string('estatus')->default('cerrado');
            $table->string('usuario')->default('recepcion');
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
        Schema::dropIfExists('pagos');
    }
}
