<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $precioProducto = $this->faker->randomFloat(2, 0,1000);
        $precioDiseno = $this->faker->randomFloat(2, 0,1000);
        $precioEspecificaciones = $this->faker->randomFloat(2, 0,1000);
        $precioEnvio = $this->faker->randomFloat(2, 0,1000);
        $pago = $this->faker->randomFloat(2, 0,1000);
        $precioTotal = $precioProducto + $precioDiseno + $precioEspecificaciones + $precioEnvio - $pago;
        return [
            'codigo' => $this->faker->numberBetween(1000, 9999),
            'producto' => $this->faker->word,
            'medida' => $this->faker->word,
            'cantidad' => $this->faker->numberBetween(1, 999),
            'esp' => $this->faker->word,
            'gr' => $this->faker->randomElement(['150 gr','90 gr']),
            'lados' => $this->faker->randomElement(['1 lado solo', '2 lados iguales', '2 lados diferentes']),
            'diseno' => $this->faker->randomElement(['nuevo', 'envia el cliente', 'correccion, mismo diseno']),
            'descripcion' => $this->faker->text,
            'estado' => $this->faker->randomElement(['Diseño', 'Impresion', 'Entrega', 'Deudor']),
            'fecha' => $this->faker->date(),
            'fechaEntrega' => $this->faker->date(),
            'fechaEspecial' => $this->faker->date(),
            'precioProducto' => $precioProducto,
            'precioDiseno' => $precioDiseno,

            'especificaciones' => $this->faker->word,
            'terminacion' => $this->faker->word,
            'envio' => $this->faker->randomElement(['Si', 'No']),
            'precioEspecificaciones' => $precioEspecificaciones,
            'precioEnvio' => $precioEnvio,

            'pago' => $pago,
            'metodoPago' => $this->faker->randomElement(['Efectivo', 'Tarjeta', 'Transferencia', 'Cheque']),
            'comentarioPago' => $this->faker->text,
            'iva' => $this->faker->randomElement(['10%', '15%', '20%']),
            'seFacturo' => $this->faker->randomElement(['Si', 'No']),

            'precioTotal' => $precioTotal,
            'empresa_id',
            'user_id',
            'sucursal_id',
            'facturacion_id',
            'direccion_id',
            'persona_id',
            'phone_id',
        ];
    }
}
