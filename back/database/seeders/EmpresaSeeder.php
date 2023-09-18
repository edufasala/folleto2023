<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresasAntiguas = DB::connection('mysql2')->select("
select b.id empresa_id, b.name empresa, c.reference referencia,b.phone telefono,
       c.name_contact contacto, c.address direccion,c.comments comentarios,
       b.created_at fecha_alta_empresa, b.updated_at fecha_modificacion_empresa,
c.id cliente_id, c.name cliente,c.charge cargo,
c.created_at fecha_alta_cliente, c.updated_at fecha_modificacion_cliente
from branchs b
inner join clients c on c.id = b.client_id;
");
        $contador = 0;
        $insertEmpresa = [];
        $insertPersona = [];
        $insertDireccion = [];
        $insertSucursal = [];
        $insertPhone = [];
        foreach ($empresasAntiguas as $empresaAntigua) {
            $contador++;
            error_log($contador);
            $insertEmpresa[] = [
                'id' => $empresaAntigua->empresa_id,
                'nombre' => $empresaAntigua->empresa,
                'contacto' => $empresaAntigua->contacto,
                'vendedor' => $empresaAntigua->cliente,
                'created_at' => $empresaAntigua->fecha_alta_empresa,
                'updated_at' => $empresaAntigua->fecha_modificacion_empresa,
            ];
            if ($empresaAntigua->telefono!=null){
                $insertPhone[] = [
                    'phone' => $empresaAntigua->telefono,
                    'person_id' => $empresaAntigua->cliente_id,
                    'created_at' => $empresaAntigua->fecha_alta_empresa,
                    'updated_at' => $empresaAntigua->fecha_modificacion_empresa,
                ];
            }
            $insertPersona[] = [
                'nombre' => $empresaAntigua->cliente,
                'cargo' => $empresaAntigua->cargo,
                'dni' => $empresaAntigua->cliente_id,
                'empresa_id' => $empresaAntigua->empresa_id,
                'created_at' => $empresaAntigua->fecha_alta_cliente,
                'updated_at' => $empresaAntigua->fecha_modificacion_cliente,
            ];
            $insertDireccion[] = [
                'direccion' => $empresaAntigua->direccion,
                'codigoPostal'=>'0000',
                'localidad'=>'',
                'empresa_id' => $empresaAntigua->empresa_id,
                'created_at' => $empresaAntigua->fecha_alta_empresa,
                'updated_at' => $empresaAntigua->fecha_modificacion_empresa,
            ];
            $insertSucursal[] = [
                'nombre' => $empresaAntigua->direccion,
                'comentario'=> $empresaAntigua->comentarios,
                'empresa_id' => $empresaAntigua->empresa_id,
                'created_at' => $empresaAntigua->fecha_alta_empresa,
                'updated_at' => $empresaAntigua->fecha_modificacion_empresa,
            ];
        }
        DB::table('empresas')->insert($insertEmpresa);
        DB::table('people')->insert($insertPersona);
        DB::table('direccions')->insert($insertDireccion);
        DB::table('sucursals')->insert($insertSucursal);
        DB::table('phones')->insert($insertPhone);
    }
}
