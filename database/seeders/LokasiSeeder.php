<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lokasis')->insert([
            ['nama_lokasi' => 'LAB 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'LAB 2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'LAB 3', 'created_at' => now(), 'updated_at' => now()],
            ['nama_lokasi' => 'RUANG UKS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
