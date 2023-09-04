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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo')->nullable();
            $table->string('producto')->nullable();
            $table->string('medida')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('esp')->nullable();
            $table->string('gr')->nullable();
            $table->string('lados')->nullable();
            $table->string('diseno')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('estado')->nullable()
                ->comment('En donde se ecuentra el pedido (Diseño, Impresion, Taller, Terminacion, Entregas)');
            $table->string('estadoPedido')->nullable()
                ->comment("Estado del pedido ('Activo', 'Atrasado', 'StandBy', 'Deudor', 'Cancelado','Terminados')");
            $table->date('fecha')->nullable();
            $table->integer('diasCompra')->nullable();
            $table->date('fechaEntrega')->nullable();
            $table->date('fechaEspecial')->nullable();
            $table->double('precioProducto',11,2)->nullable();
            $table->double('precioDiseno',11,2)->nullable();

            $table->string('especificaciones')->nullable();
            $table->string('terminacion')->nullable();
            $table->string('envio')->nullable();
            $table->double('precioEspecificaciones',11,2)->nullable();
            $table->double('precioEnvio',11,2)->nullable();

            $table->integer('pago')->nullable();
            $table->string('metodoPago')->nullable();
            $table->string('comentarioPago')->nullable();
            $table->integer('iva')->nullable();
            $table->string('seFacturo')->nullable();

//            $table->double('precioTotal',11,2)->nullable();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');

            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id')->references('id')->on('facturacions');

            $table->unsignedBigInteger('direccion_id')->nullable();
            $table->foreign('direccion_id')->references('id')->on('direccions');

            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('people');

            $table->unsignedBigInteger('phone_id')->nullable();
            $table->foreign('phone_id')->references('id')->on('phones');

            $table->unsignedBigInteger('email_id')->nullable();
            $table->foreign('email_id')->references('id')->on('emails');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
