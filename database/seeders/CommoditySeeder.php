<?php

namespace Database\Seeders;

use App\CommodityLocation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commodities = collect([
            'Meja',
            'Kursi',
            'Kursi Roda Dua',
            'Lemari Kamera',
            'Lemari Buku',
            'Lemari Sepatu',
            'Penghapus Papan Tulis Putih',
            'Meja Guru',
            'Kursi Guru',
            'Rak Sepatu',
            'Rak Peralatan Sekolah',
            'Rak Helm',
            'Rak Sepatu Guru',
            'Rak Helm Guru',
            'Papan Tulis Putih',
            'Papan Tulis Hitam',
            'Kipas Dinding',
            'Kipas Angin Portabel',
            'Kipas Angin',
        ]);

        $brands = collect([
            'IKEA',
            'Livien',
            'iFurnholic',
            'Red Sun',
            'JYSXK',
            'Olympic',
            'Informa',
            "Dove's",
            'Funika',
            'Atria',
            'Vivere',
        ]);

        $materials = collect([
            'Kayu Solid',
            'Kayu Lapis (Plywood/Multipleks)',
            'Blockboard',
            'MDF (Medium Density Fibreboard)',
            'Melaminto',
            'Partikel',
            'Rotan',
        ]);

        $conditions = collect([1, 2, 3]);
        $locationIds = CommodityLocation::pluck('id');

        $data = $commodities->map(fn ($commodity) => [
            'commodity_acquisition_id' => mt_rand(1, 2),
            'commodity_location_id' => $locationIds->random(),
            'item_code' => 'BRG-'.mt_rand(1000, 9999).mt_rand(100, 999),
            'name' => $commodity,
            'brand' => $brands->random(),
            'material' => $materials->random(),
            'year_of_purchase' => mt_rand(2010, date('Y')),
            'condition' => $conditions->random(),
            'quantity' => $quantity = mt_rand(50, 200),
            'price' => $quantity * ($pricePerItem = mt_rand(2500, 150000)),
            'price_per_item' => $pricePerItem,
            'note' => 'Keterangan barang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('commodities')->insert($data->toArray());
    }
}
