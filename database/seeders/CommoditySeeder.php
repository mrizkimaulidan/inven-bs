<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/** Seed sample commodities with catalog relationships. */
class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $commodityLocationIds = CommodityLocation::pluck('id');
        $fundingSourceIds = CommodityFundingSource::pluck('id');
        $brandIds = Brand::pluck('id');
        $materialIds = Material::pluck('id');

        $commodityNames = collect([
            'Meja', 'Kursi', 'Kursi Roda Dua', 'Lemari Kamera', 'Lemari Buku',
            'Lemari Sepatu', 'Penghapus Papan Tulis Putih', 'Meja Guru', 'Kursi Guru',
            'Rak Sepatu', 'Rak Peralatan Sekolah', 'Rak Helm', 'Rak Sepatu Guru',
            'Rak Helm Guru', 'Papan Tulis Putih', 'Papan Tulis Hitam',
            'Kipas Dinding', 'Kipas Angin Portabel', 'Kipas Angin',
        ]);

        $conditions = collect([1, 2, 3]);

        $commodityRecords = $commodityNames->map(fn (string $commodityName) => [
            'commodity_funding_source_id' => $fundingSourceIds->random(),
            'commodity_location_id' => $commodityLocationIds->random(),
            'created_by' => 1,
            'updated_by' => 1,

            'brand_id' => $brandIds->random(),
            'material_id' => $materialIds->random(),

            'item_code' => 'BRG-'.rand(100000, 999999),
            'name' => $commodityName,
            'purchase_year' => rand(2010, date('Y')),
            'condition' => $conditions->random(),

            'image' => Str::slug($commodityName).'.jpg',

            'quantity' => $quantity = rand(5, 50),
            'total_price' => $quantity * ($unitPrice = rand(2500, 150000)),
            'unit_price' => $unitPrice,
            'notes' => "Keterangan barang $commodityName",

            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        Commodity::insert($commodityRecords);
    }
}
