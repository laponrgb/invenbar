<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
     public function run(): void
    {
        $this->call([
            SumberDanaSeeder::class,
            RolePermissionSeeder::class,
            KategoriSeeder::class,
            LokasiSeeder::class,
            BarangSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name'  => 'Administrator',
            'email' => 'admin@mail.com',
        ]);

        $petugas = User::factory()->create([
            'name'  => 'Petugas Inventaris',
            'email' => 'petugas@mail.com',
        ]);

        $admin->assignRole('admin');
        $petugas->assignRole('petugas');
    }
}
