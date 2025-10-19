<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // === Barang ===
        Permission::create(['name' => 'manage barang']);
        Permission::create(['name' => 'delete barang']);

        // === Kategori ===
        Permission::create(['name' => 'view kategori']);
        Permission::create(['name' => 'manage kategori']);

        // === Lokasi ===
        Permission::create(['name' => 'view lokasi']);
        Permission::create(['name' => 'manage lokasi']);

        // === Sumber Dana ===
        Permission::create(['name' => 'view sumberdana']);
        Permission::create(['name' => 'manage sumberdana']);

        // === Role setup ===
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);

        // Petugas hanya bisa melihat & kelola barang, kategori, lokasi
        $petugasRole->givePermissionTo([
            'manage barang',
            'view kategori',
            'view lokasi',
            'view sumberdana',
        ]);

        // Admin punya semua izin
        $adminRole->givePermissionTo(Permission::all());
    }
}
