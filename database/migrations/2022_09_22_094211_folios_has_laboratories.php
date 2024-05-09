<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FoliosHasLaboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folios_has_laboratories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folios_id');
            $table->unsignedBigInteger('laboratory_id');
            $table->timestamps();

            $table->foreign('folios_id')->references('id')->on('folios')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('folios_has_laboratories');
    }
}
