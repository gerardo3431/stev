<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyHistorialsHasRecepcions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historials_has_recepcions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('picture_id')->nullable();

            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historials_has_recepcions', function (Blueprint $table) {
            //
            $table->dropForeign('estudios_has_laboratories_picture_id_foreign');
        });
    }
}
