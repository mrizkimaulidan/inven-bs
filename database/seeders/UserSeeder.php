<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret')
        ]);

        User::create([
            'name' => 'Staff TU (Tata Usaha)',
            'email' => 'stafftu@mail.com',
            'password' => bcrypt('secret')
        ]);
    }
}
