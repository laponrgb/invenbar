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
            ['nama_sumberdana' => 'Dana BOS', 'created_at' => now(), 'updated_at' => now()],
            ['nama_sumberdana' => 'Komite Sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_sumberdana' => 'Bantuan Pemerintah', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
