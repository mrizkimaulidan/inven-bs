<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
            'Ruang Kegiatan Ekstrakurikuler',
        ];

        $data = collect($locations)
            ->map(fn ($location, $index) => [
                'name' => $location,
                'description' => 'Ruangan '.($index + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->merge(
                collect(range(1, 5))->map(fn ($i) => [
                    'name' => 'Kelas '.$i,
                    'description' => 'Ruangan Kelas '.$i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            )
            ->toArray();

        DB::table('commodity_locations')->insert($data);
    }
}
