<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeparmentsHasLaboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deparments_has_laboratories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deparments_id');
            $table->unsignedBigInteger('laboratory_id');
            $table->timestamps();

            $table->foreign('deparments_id')->references('id')->on('deparments')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('laboratory_id')->references('id')->on('laboratories')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deparments_has_laboratories');
    }
}
