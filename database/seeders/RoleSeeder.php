<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect([
            ['name' => 'Administrator',],
            ['name' => 'Staff TU (Tata Usaha)']
        ]);

        $roles = $roles->map(function ($role) {
            $role['guard_name'] = 'web';
            $role['created_at'] = now();
            $role['updated_at'] = $role['created_at'];

            return $role;
        });

        Role::insert($roles->toArray());
    }
}
