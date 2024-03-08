<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuNames = collect(['barang', 'bos', 'ruangan', 'pengguna']);
        $permissionNames = ['tambah', 'lihat', 'ubah', 'hapus'];

        $permissions = $menuNames->flatMap(function ($menuName) use ($permissionNames) {
            return collect($permissionNames)->map(function ($permissionName) use ($menuName) {
                return [
                    'name' => $permissionName . ' ' . $menuName,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            });
        })->collect();

        $mergedPermissions = $permissions->merge([
            ['name' => 'import barang', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'export barang', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'print barang', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'print individual barang', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mengatur profile', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert($mergedPermissions->toArray());
    }
}
