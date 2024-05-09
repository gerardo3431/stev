<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrefoliosHasRecepcions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefolios_has_recepcions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prefolio_id');
            $table->unsignedBigInteger('recepcions_id');
            $table->timestamps();

            $table->foreign('prefolio_id')->references('id')->on('prefolios')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefolios_has_recepcions');
    }
}
