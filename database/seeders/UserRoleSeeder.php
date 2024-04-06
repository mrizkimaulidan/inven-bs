<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::take(2)->get();

        $user[0]->assignRole('Administrator');
        $user[1]->assignRole('Staff TU (Tata Usaha)');
    }
}
