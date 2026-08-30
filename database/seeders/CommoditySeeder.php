<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locationIds = CommodityLocation::pluck('id');
        $fundingIds = CommodityFundingSource::pluck('id');
        $brandIds = Brand::pluck('id');
        $materialIds = Material::pluck('id');

        $commodities = collect([
            'Meja', 'Kursi', 'Kursi Roda Dua', 'Lemari Kamera', 'Lemari Buku',
            'Lemari Sepatu', 'Penghapus Papan Tulis Putih', 'Meja Guru', 'Kursi Guru',
            'Rak Sepatu', 'Rak Peralatan Sekolah', 'Rak Helm', 'Rak Sepatu Guru',
            'Rak Helm Guru', 'Papan Tulis Putih', 'Papan Tulis Hitam',
            'Kipas Dinding', 'Kipas Angin Portabel', 'Kipas Angin',
        ]);

        $conditions = collect([1, 2, 3]);

        $transformedData = $commodities->map(fn (string $commodity) => [
            'commodity_funding_source_id' => $fundingIds->random(),
            'commodity_location_id' => $locationIds->random(),
            'created_by' => 1,
            'updated_by' => 1,

            'brand_id' => $brandIds->random(),
            'material_id' => $materialIds->random(),

            'item_code' => 'BRG-'.rand(100000, 999999),
            'name' => $commodity,
            'purchase_year' => rand(2010, date('Y')),
            'condition' => $conditions->random(),

            'quantity' => $qty = rand(5, 50),
            'total_price' => $qty * ($price = rand(2500, 150000)),
            'unit_price' => $price,
            'notes' => "Keterangan barang $commodity",

            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        Commodity::insert($transformedData);
    }
}
