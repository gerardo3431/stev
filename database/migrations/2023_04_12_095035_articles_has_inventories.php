<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArticlesHasInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // $table->foreignId('article_id')->constrained();
    // $table->foreignId('warehouse_id')->constrained();
    public function up()
    {
        Schema::create('articles_has_inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('inventorie_id');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('inventorie_id')->references('id')->on('inventories')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_has_inventories');
    }
}
