<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubsidiaryHasUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsidiary_has_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subsidiary_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('subsidiary_id')->references('id')->on('subsidiaries')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('subsidiary_has_user');
    }
}
