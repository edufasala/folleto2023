<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('text_medidas')->insert([
            ["name"=>"10x15"],
            ["name"=>"15x21"],
            ["name"=>"21x30"],
            ["name"=>"30x40"],
            ["name"=>"40x50"],
            ["name"=>"50x70"],
            ["name"=>"70x100"],
            ["name"=>"100x140"],
            ["name"=>"140x200"],
            ["name"=>"200x300"],
        ]);
    }
}
