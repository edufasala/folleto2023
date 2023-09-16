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
select b.id empresa_id, b.name empresa, c.reference referencia, c.name_contact contacto,
       b.created_at fecha_alta_empresa, b.updated_at fecha_modificacion_empresa,
c.id cliente_id, c.name cliente
from branchs b
inner join clients c on c.id = b.client_id;
");
        foreach ($empresasAntiguas as $empresaAntigua) {
            $empresa=DB::table('empresas')->insert([
                'id' => $empresaAntigua->empresa_id,
                'nombre' => $empresaAntigua->empresa,
                'contacto' => $empresaAntigua->contacto,
                'vendedor' => $empresaAntigua->cliente,
                'created_at' => $empresaAntigua->fecha_alta_empresa,
                'updated_at' => $empresaAntigua->fecha_modificacion_empresa,
            ]);
        }

    }
}
