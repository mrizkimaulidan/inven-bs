<?php

namespace Database\Seeders;

use App\Models\CommodityLocation;
use Illuminate\Database\Seeder;

/** Seed the initial commodity storage locations. */
class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $locationNames = collect([
            /** Administration and staff locations. */
            'Ruang Guru',
            'Ruang Kepala Sekolah',
            'Ruang Wakil Kepala Sekolah',
            'Ruang Staff Tata Usaha (TU)',
            'Ruang Kepala Tata Usaha (TU)',
            'Ruangan Guru BP (Bimbingan Penyuluhan)',

            /** Learning and laboratory locations. */
            'Ruang Laboratorium',
            'Ruang Komputer',
            'Ruang Praktek',
            'Perpustakaan Bawah',
            'Perpustakaan Atas',

            /** Classroom locations. */
            'Kelas 1',
            'Kelas 2',
            'Kelas 3',
            'Kelas 4',
            'Kelas 5',
            'Kelas 6',

            /** Activity locations. */
            'Ruang OSIS',
            'Ruang Seni Musik',
            'Ruang Kegiatan Ekstrakurikuler',
            'Ruang Serba Guna',

            /** Facility locations. */
            'Ruang Gudang',
            'Ruang Kantin',
            'Ruang Koperasi',
            'Ruang Satpam/Pos Satpam',
            'Ruang Salat',
            'Ruang Unit Kesehatan Sekolah (UKS)',
            'Lapangan Upacara',
            'Lapangan Olahraga',
        ]);

        CommodityLocation::factory()->count(30)->create();
    }
}
