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
        Schema::create('producto_sin_pliegos', function (Blueprint $table) {
            $table->id();
            $table->string('productoServicio')->nullable();
            $table->string('imprime')->nullable();
            $table->string('nombre')->nullable();
            $table->string('tipoMaterial')->nullable();
            $table->string('gr')->nullable();
            $table->string('tamano')->nullable();
            $table->string('seModifica')->nullable();
            $table->string('fracciona')->nullable();
            $table->string('espacios')->nullable();
            $table->integer('desde')->nullable();
            $table->integer('hasta')->nullable();
            $table->double('precio',11,2)->nullable();
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_sin_pliegos');
    }
};
