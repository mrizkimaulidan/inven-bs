<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => 'secret',
        ]);
        $administrator->assignRole('Administrator');

        $staff = User::create([
            'name' => 'Staff TU (Tata Usaha)',
            'email' => 'stafftu@mail.com',
            'password' => 'secret',
        ]);
        $staff->assignRole('Staff TU (Tata Usaha)');
    }
}
