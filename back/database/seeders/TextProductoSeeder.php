<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('text_productos')->insert([
            ["name"=>'Folletos'],
            ["name"=>'Tarjetas'],
            ["name"=>'Afiches'],
            ["name"=>'Banner'],
            ["name"=>'Diseño'],
            ["name"=>'Logo'],
            ["name"=>'Otros'],
        ]);
    }
}
