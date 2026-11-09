<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/** Create application roles and assign their permissions. */
class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $menuNames = collect(['barang', 'perolehan', 'ruangan', 'merek', 'bahan', 'pengguna', 'peran']);
        $actions = collect(['tambah', 'ubah', 'hapus', 'lihat', 'detail', 'impor', 'ekspor', 'print']);

        $menuNames->each(function (string $menu) use ($actions): void {
            $actions->each(fn (string $action) => Permission::firstOrCreate(['name' => "{$action} {$menu}"])
            );
        });
        Permission::where('name', 'lihat dashboard')->delete();

        $admin = Role::firstOrCreate(['name' => 'Administrator']);
        $staff = Role::firstOrCreate(['name' => 'Staff TU (Tata Usaha)']);

        $admin->syncPermissions(Permission::pluck('id'));
        $staff->syncPermissions(
            Permission::whereNotLike('name', '% pengguna')
                ->whereNotLike('name', '% peran')
                ->pluck('id')
        );

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
