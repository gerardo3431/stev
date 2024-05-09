<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrefoliosHasLaboratories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefolios_has_laboratories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prefolio_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('laboratory_id');
            $table->timestamps();

            $table->foreign('prefolio_id')->references('id')->on('prefolios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('prefolios_has_laboratories');
    }
}
