<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Requests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->text('observaciones');
            $table->string('tipo');
            $table->string('solicitud');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('requested_id');
            $table->unsignedBigInteger('approved_id')->nullable();
            $table->timestamps();

            $table->foreign('requested_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('approved_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
