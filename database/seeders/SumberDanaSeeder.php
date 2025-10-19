<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SumberDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sumberdanas')->insert([
            [
                'nama_sumberdana' => 'APBN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sumberdana' => 'APBD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sumberdana' => 'BOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sumberdana' => 'Donasi Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
