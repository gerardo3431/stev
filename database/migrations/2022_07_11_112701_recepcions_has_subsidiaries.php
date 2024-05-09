<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecepcionsHasSubsidiaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions_has_subsidiaries', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('recepcions_id');
            // $table->unsignedBigInteger('laboratory_id');
            $table->unsignedBigInteger('subsidiary_id');

            $table->timestamps();


            $table->foreign('recepcions_id')->references('id')->on('recepcions')->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('laboratory_id')->references('id')->on('laboratories')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subsidiary_id')->references('id')->on('subsidiaries')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
