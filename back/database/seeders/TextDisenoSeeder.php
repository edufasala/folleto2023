<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextDisenoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('text_disenos')->insert([
            ["name"=>'nuevo'],
            ["name"=>'envia el cliente'],
            ["name"=>'correccion'],
            ["name"=>'mismo diseno'],
        ]);
    }
}
