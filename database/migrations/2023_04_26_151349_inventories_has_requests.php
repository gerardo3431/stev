<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoriesHasRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories_has_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventories_id');
            $table->unsignedBigInteger('requests_id');
            $table->string('cantidad');
            $table->timestamps();

            $table->foreign('inventories_id')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('requests_id')->references('id')->on('requests')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories_has_requests');
    }
}
