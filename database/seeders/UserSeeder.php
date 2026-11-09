<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/** Seed the initial application user accounts. */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $administrator = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            ['name' => 'Administrator', 'password' => 'secret'],
        );
        $administrator->assignRole('Administrator');

        $staff = User::firstOrCreate(
            ['email' => 'stafftu@mail.com'],
            ['name' => 'Staff TU (Tata Usaha)', 'password' => 'secret'],
        );
        $staff->assignRole('Staff TU (Tata Usaha)');

        User::factory(50)->create()->each(
            fn (User $user) => $user->assignRole('Staff TU (Tata Usaha)'),
        );
    }
}
