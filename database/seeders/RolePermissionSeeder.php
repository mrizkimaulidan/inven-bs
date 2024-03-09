<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administratorPermissions = Permission::all();

        $staffPermissions = $administratorPermissions->reject(function ($permission) {
            return in_array($permission->name, ['lihat pengguna', 'tambah pengguna', 'ubah pengguna', 'hapus pengguna']);
        });

        $roles = Role::all();

        // administrator
        $roles[0]->syncPermissions($administratorPermissions);

        // staff
        $roles[1]->syncPermissions($staffPermissions);
    }
}
