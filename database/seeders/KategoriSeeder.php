<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['name' => 'SETUP CETAKAN NAIK'],
            ['name' => 'SETUP CETAKAN TURUN'],
            ['name' => 'SETUP SANDBLASTING'],
            ['name' => 'MAINTENANCE SANDBLASTING'],
            ['name' => 'SCHEDULE NAIK'],
            ['name' => 'SCHEDULE TURUN'],
            ['name' => 'SCHEDULE SANDBLASTING'],
        ]);
    }
}
