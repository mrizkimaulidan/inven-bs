<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            'Ruang Guru',
            'Ruang Kepala Sekolah',
            'Ruang Staff Tata Usaha (TU)',
            'Ruang Gudang',
            'Perpustakaan Bawah',
            'Perpustakaan Atas',
            'Ruang OSIS',
            'Ruang Laboratorium',
            'Ruang Unit Kesehatan Sekolah (UKS)',
            'Ruang Kantin',
            'Ruang Koperasi',
            'Ruang Satpam/Pos Satpam',
            'Ruang Salat',
            'Ruang Kepala Tata Usaha (TU)',
            'Ruang Seni Musik',
            'Ruang Wakil Kepala Sekolah',
            'Ruang Komputer',
            'Ruang Praktek',
            'Ruang Serba Guna',
            'Ruangan Guru BP (Bimbingan Penyuluhan)',
            'Ruang Kegiatan Ekstrakurikuler'
        ];

        for ($i = 1; $i < count($locations); $i++) {
            DB::table('commodity_locations')->insert([
                'name' => $locations[$i],
                'description' => 'Ruangan ' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 1; $i < 6; $i++) {
            DB::table('commodity_locations')->insert([
                'name' => 'Kelas ' . $i,
                'description' => 'Ruangan Kelas ' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
