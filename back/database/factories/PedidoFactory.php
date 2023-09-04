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
            'producto' => $this->faker->randomElement(['Folletos','Tarjetas','Afiches','Banner','Diseño','Logo','Otros']),
            'medida' => $this->faker->randomElement(['10x15','15x21','21x30','30x40','40x50','50x70','70x100','100x140','140x200','200x300']),
            'cantidad' => $this->faker->randomElement(['100','200','300','400','500','600','700','800','900','1000']),
            'esp' => $this->faker->word,
            'gr' => $this->faker->randomElement(['150','90']),
            'lados' => $this->faker->randomElement(['1 lado solo', '2 lados iguales', '2 lados diferentes']),
            'diseno' => $this->faker->randomElement(['nuevo', 'envia el cliente', 'correccion','mismo diseno']),
            'descripcion' => $this->faker->text,
            'estado' => $this->faker->randomElement(['Diseño', 'Impresion', 'Taller', 'Terminacion', 'Entregas', 'Cancelado']),
            'estadoPedido' => $this->faker->randomElement(['Activo', 'Atrasado', 'StandBy', 'Deudor', 'Cancelado', 'Terminados']),
            'diasCompra' => $this->faker->numberBetween(4, 5),
            'fecha' => $this->faker->date(),
            'fechaEntrega' => $this->faker->date(),
            'fechaEspecial' => $this->faker->date(),
            'precioProducto' => $precioProducto,
            'precioDiseno' => $precioDiseno,

            'especificaciones' => $this->faker->text,
            'terminacion' => $this->faker->text,
            'envio' => $this->faker->randomElement(['Si', 'No']),
            'precioEspecificaciones' => $precioEspecificaciones,
            'precioEnvio' => $precioEnvio,

            'pago' => $pago,
            'metodoPago' => $this->faker->randomElement(['Efectivo', 'Tarjeta', 'Transferencia', 'Cheque']),
            'comentarioPago' => $this->faker->text,
            'iva' => $this->faker->randomElement(['10%', '15%', '20%']),
            'seFacturo' => $this->faker->randomElement(['Si', 'No']),

            'precioTotal' => $precioTotal,
            'user_id' => $this->faker->numberBetween(1, 10),
//            'sucursal_id' => $this->faker->numberBetween(1, 10),
//            'facturacion_id' => $this->faker->numberBetween(1, 10),
//            'direccion_id' => $this->faker->numberBetween(1, 10),
//            'persona_id' => $this->faker->numberBetween(1, 10),
//            'phone_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
