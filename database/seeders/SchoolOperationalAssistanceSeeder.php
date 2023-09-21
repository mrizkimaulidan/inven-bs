<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolOperationalAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_operational_assistances')->insert([
            'name' => 'BOSDA',
            'description' => 'Deskripsi BOSDA',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('school_operational_assistances')->insert([
            'name' => 'BOSNAS',
            'description' => 'Deskripsi BOSNAS',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
