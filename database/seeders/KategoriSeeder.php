<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Perangkat Elektronik', 'created_at' => now(),'updated_at' => now(),],
            ['nama_kategori' => 'Peralatan Jaringan & Teknologi', 'created_at' => now(),'updated_at' => now(),],
            ['nama_kategori' => 'Peralatan Kesehatan & P3K', 'created_at' => now(),'updated_at' => now(),],
            ['nama_kategori' => 'Perabotan & Fasilitas Ruangan', 'created_at' => now(),'updated_at' => now(),],
            ['nama_kategori' => 'Kebersihan & Sanitasi', 'created_at' => now(),'updated_at' => now(),],
            ['nama_kategori' => 'Dokumentasi & Administrasi', 'created_at' => now(),'updated_at' => now(),],
        ]);
    }
}