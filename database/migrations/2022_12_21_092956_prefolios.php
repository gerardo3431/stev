<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Prefolios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefolios', function (Blueprint $table) {
            $table->id();
            $table->string('prefolio');
            $table->string('nombre');
            $table->string('observaciones')->nullable();
            $table->string('doctor')->nullable();
            $table->text('adjunto')->nullable();
            $table->string('estado');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefolios');
    }
}
