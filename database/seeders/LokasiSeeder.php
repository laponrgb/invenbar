<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
     public function run(): void
    {
        DB::table('lokasis')->insert([
            [
                'nama_lokasi' => 'Ruang Rapat Utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Lobi Depan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Gudang Arsip',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Ruang Kepala Dinas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
