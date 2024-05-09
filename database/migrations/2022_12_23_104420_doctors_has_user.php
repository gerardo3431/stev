<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DoctorsHasUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctores_has_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctores_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('doctores_id')->references('id')->on('doctores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctores_has_users');
    }
}
