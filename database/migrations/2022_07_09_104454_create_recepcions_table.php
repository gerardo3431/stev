<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions', function (Blueprint $table) {
            $table->id();

            $table->string('folio');
            $table->string('numRegistro')->nullable();
            
            
            $table->string('fecha_entrega')->nullable();
            $table->string('tipPasiente')->nullable();
            $table->string('turno')->nullable();
            
            //--------------------------------------------
            $table->string('numCama')->nullable(); 
            $table->string('peso')->nullable();
            $table->string('talla')->nullable();
            $table->string('fur')->nullable();
            //nuevos--------------------------------------
            $table->string('f_flebotomia')->nullable();
            $table->string('h_flebotomia')->nullable();
            $table->string('num_vuelo')->nullable();
            $table->string('pais_destino')->nullable();
            $table->string('aerolinea')->nullable();
            //--------------------------------------------
            $table->string('medicamento')->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('listPrecio')->nullable();
            //maquila--------------------------------------
            $table->string('res_file')->nullable();
            $table->string('res_file_img')->nullable();
            $table->string('maq_file')->nullable();
            $table->string('maq_file_img')->nullable();
            $table->string('patient_file')->nullable();

            
            $table->string('num_total')->nullable();
            $table->string('descuento')->default(0)->nullable();
            
            $table->string('estado')->default('no pagado');
            $table->string('estatus_solicitud')->default('solicitado');

            $table->string('token');

            $table->foreignId('id_paciente')->nullable()->constrained('pacientes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_empresa')->nullable()->constrained('empresas')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_doctor')->nullable()->constrained('doctores')->cascadeOnUpdate()->nullOnDelete();

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
        Schema::dropIfExists('recepcions');

    }
}
