<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pedidosAntiguos = DB::connection('mysql2')->select("
        select *
        from orders
        where branch_id in (select id from branchs);
        ");
        $contador = 0;
        $insertPedido = [];
        foreach ($pedidosAntiguos as $pedidoAntiguo) {
            $contador++;
            error_log($contador);
            $insertPedido[] = [
                'codigo' => 1,
                'producto' => $pedidoAntiguo->product,
                'medida' => $pedidoAntiguo->size,
                'cantidad' => $pedidoAntiguo->quantity,
                'esp' => $pedidoAntiguo->spaces,
                'gr' => $pedidoAntiguo->garnet,
                'lados' => '',
                'diseno' => $pedidoAntiguo->design,
                'descripcion' => $pedidoAntiguo->contact_design,
                'estado' => '',
                'estadoPedido' => 'Terminados',
                'diasCompra' => 0,
                'fecha' => date('Y-m-d', strtotime($pedidoAntiguo->created_at)),
                'fechaEntrega' => now(),
                'fechaEspecial' => now(),
                'precioProducto' => $pedidoAntiguo->price_flyer,
                'precioDiseno' => $pedidoAntiguo->price_design,

                'especificaciones' => '',
                'terminacion' => '',
                'envio' => 'No',
                'precioEspecificaciones' => $pedidoAntiguo->price_flyer_special,
                'precioEnvio' => $pedidoAntiguo->price_send,

                'pago' => 0,
                'metodoPago' => 'Efectivo',
                'comentarioPago' => '',
                'iva' => 0,
                'seFacturo' => 'Si',
                'user_id' => 1,
                'empresa_id' => $pedidoAntiguo->branch_id,
                'created_at' => $pedidoAntiguo->created_at,
                'updated_at' => $pedidoAntiguo->updated_at,
            ];
            if ($contador%1000==0){
                DB::table('pedidos')->insert($insertPedido);
                $insertPedido = [];
            }
        }
//        DB::table('pedidos')->insert($insertPedido);
    }
}
