<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyRecepcions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recepcions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('captura_id')->nullable();
            $table->unsignedBigInteger('valida_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();


            $table->foreign('captura_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('valida_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::table('recepcions', function (Blueprint $table) {
            //
            $table->dropForeign('estudios_has_laboratories_captura_id_foreign');
            $table->dropForeign('estudios_has_laboratories_valida_id_foreign');

        });
    }
}
