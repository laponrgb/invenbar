<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'kode_barang' => 'LPO01',
                'nama_barang' => 'Laptop Dell Latitude 5420',
                'kategori_id' => 1,
                'lokasi_id' => 4,
                'jumlah' => 9, // total semua kondisi
                'satuan' => 'Unit',
                'jumlah_baik' => 3,
                'jumlah_rusak_ringan' => 1,
                'jumlah_rusak_berat' => 5,
                'tanggal_pengadaan' => '2023-05-15',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'PRJ01',
                'nama_barang' => 'Proyektor Epson EB-X500',
                'kategori_id' => 1,
                'lokasi_id' => 1,
                'jumlah' => 2,
                'satuan' => 'Unit',
                'jumlah_baik' => 2,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'tanggal_pengadaan' => '2022-11-20',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'MJ001',
                'nama_barang' => 'Meja Rapat Kayu Jati',
                'kategori_id' => 2,
                'lokasi_id' => 1,
                'jumlah' => 1,
                'satuan' => 'Buah',
                'jumlah_baik' => 1,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'tanggal_pengadaan' => '2021-02-10',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'ATK-SP-01',
                'nama_barang' => 'Spidol Whiteboard Snowman',
                'kategori_id' => 3,
                'lokasi_id' => 3,
                'jumlah' => 50,
                'satuan' => 'Pcs',
                'jumlah_baik' => 48,
                'jumlah_rusak_ringan' => 2,
                'jumlah_rusak_berat' => 0,
                'tanggal_pengadaan' => '2024-01-30',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
