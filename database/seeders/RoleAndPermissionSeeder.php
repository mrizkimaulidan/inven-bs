<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuNames = collect(['barang', 'perolehan', 'ruangan', 'merek', 'bahan', 'pengguna']);
        $actions = collect(['tambah', 'ubah', 'hapus', 'lihat', 'detail', 'impor', 'ekspor', 'print']);

        $menuNames->each(function (string $menu) use ($actions) {
            $actions->each(fn (string $action) => Permission::firstOrCreate(['name' => "{$action} {$menu}"])
            );
        });

        $admin = Role::firstOrCreate(['name' => 'Administrator']);
        $staff = Role::firstOrCreate(['name' => 'Staff TU (Tata Usaha)']);

        $admin->syncPermissions(Permission::pluck('id'));
        $staff->syncPermissions(
            Permission::whereNotLike('name', '%pengguna')->pluck('id')
        );
    }
}
