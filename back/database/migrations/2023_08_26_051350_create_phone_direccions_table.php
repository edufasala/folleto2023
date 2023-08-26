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
        Schema::create('phone_direccions', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->unsignedBigInteger('direccion_id');
            $table->foreign('direccion_id')->references('id')->on('direccions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_direccions');
    }
};
