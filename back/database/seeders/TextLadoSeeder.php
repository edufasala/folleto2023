<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextLadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('text_lados')->insert([
            ["name"=>'1 lado solo'],
            ["name"=>'2 lados iguales'],
            ["name"=>'2 lados diferentes'],
        ]);
    }
}
