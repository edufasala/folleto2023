<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto_terminacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('gr')->nullable();
            $table->string('tamanoMaximo')->nullable();
            $table->string('tamanoMinimo')->nullable();
            $table->string('desde')->nullable();
            $table->double('precio',11,2)->nullable();
            $table->integer('primeros1000')->nullable();
            $table->integer('siguientes1000')->nullable();
            $table->text('comentario')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_terminacions');
    }
};
