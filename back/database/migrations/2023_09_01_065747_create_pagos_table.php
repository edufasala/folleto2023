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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo')->nullable()->comment('Seña, Pago');
            $table->double('monto',11,2);
            $table->string('facturado')->nullable()->default('No');
            $table->string('estado')->nullable()->default('Pendiente')->comment('Aceptado, Rechazado, Pendiente');
            $table->string('metodoPago')->nullable()->comment('Efectivo, Transferencia, Tarjeta, Cheque, Otro');
            $table->string('comentario')->nullable();
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id')->references('id')->on('facturacions');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
