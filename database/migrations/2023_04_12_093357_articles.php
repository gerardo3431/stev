<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->string('clave_salud')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->string('nombre');
            $table->string('nombre_corto')->nullable();
            $table->string('tipo_material');
            $table->string('unidad');
            $table->string('pieza')->default('off');
            $table->string('cantidad')->nullable();
            $table->string('referencia')->nullable();
            $table->string('marca')->nullable();
            $table->string('partida')->nullable();
            $table->string('ubicacion')->nullable();//que departamento tiene parte del inventario del articulo
            $table->string('presentacion');
            $table->string('lote')->default('off');
            $table->string('caducidad')->default('off');
            $table->string('ultimo_precio')->nullable();
            $table->string('min_stock')->default(1);
            $table->string('max_stock');
            $table->string('punto_reorden')->nullable();
            // $table->string('familia')->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
