<?php

namespace Database\Seeders;

use App\Models\CommodityLocation;
use Illuminate\Database\Seeder;

class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = collect([
            // Administrasi & Guru
            'Ruang Guru',
            'Ruang Kepala Sekolah',
            'Ruang Wakil Kepala Sekolah',
            'Ruang Staff Tata Usaha (TU)',
            'Ruang Kepala Tata Usaha (TU)',
            'Ruangan Guru BP (Bimbingan Penyuluhan)',

            // Belajar & Lab
            'Ruang Laboratorium',
            'Ruang Komputer',
            'Ruang Praktek',
            'Perpustakaan Bawah',
            'Perpustakaan Atas',

            // Kelas
            'Kelas 1',
            'Kelas 2',
            'Kelas 3',
            'Kelas 4',
            'Kelas 5',
            'Kelas 6',

            // Kegiatan
            'Ruang OSIS',
            'Ruang Seni Musik',
            'Ruang Kegiatan Ekstrakurikuler',
            'Ruang Serba Guna',

            // Fasilitas
            'Ruang Gudang',
            'Ruang Kantin',
            'Ruang Koperasi',
            'Ruang Satpam/Pos Satpam',
            'Ruang Salat',
            'Ruang Unit Kesehatan Sekolah (UKS)',
            'Lapangan Upacara',
            'Lapangan Olahraga',
        ]);

        $now = now();

        $transformedData = $locations->map(fn (string $location) => [
            'name' => $location,
            'description' => "Lokasi: $location",
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        CommodityLocation::insert($transformedData);
    }
}
