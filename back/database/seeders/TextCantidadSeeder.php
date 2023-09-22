<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextCantidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('text_cantidads')->insert([
            ["name"=>'100'],
            ["name"=>'200'],
            ["name"=>'300'],
            ["name"=>'400'],
            ["name"=>'500'],
            ["name"=>'600'],
            ["name"=>'700'],
            ["name"=>'800'],
            ["name"=>'900'],
            ["name"=>'1000'],
        ]);
    }
}
