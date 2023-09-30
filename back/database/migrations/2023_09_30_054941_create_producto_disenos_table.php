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
        Schema::create('producto_disenos', function (Blueprint $table) {
            $table->id();
            $table->string('diseno')->nullable();
            $table->string('tamano')->nullable();
            $table->string('lado')->nullable();
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
        Schema::dropIfExists('producto_disenos');
    }
};
