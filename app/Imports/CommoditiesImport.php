<?php

namespace App\Imports;

use App\Enums\CommodityCondition;
use App\Models\Commodity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create inventory records from spreadsheet rows with placeholder foreign keys.
 */
class CommoditiesImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Create a commodity from spreadsheet values and placeholder relationships.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     * @return Model|null
     */
    public function model(array $spreadsheetRow): ?Model
    {
        return new Commodity([
            'commodity_funding_source_id' => 1,
            'commodity_location_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'brand_id' => 1,
            'material_id' => 1,
            'item_code' => $spreadsheetRow['kode_barang'],
            'qr_code' => (string) Str::ulid(),
            'name' => $spreadsheetRow['nama_barang'],
            'purchase_year' => $spreadsheetRow['tahun_pembelian'],
            'condition' => CommodityCondition::fromLabel($spreadsheetRow['kondisi']),
            'image' => 'img/products/product-1.jpg',
            'quantity' => $spreadsheetRow['jumlah'],
            'unit_price' => $spreadsheetRow['harga_satuan'],
            'total_price' => $spreadsheetRow['jumlah'] * $spreadsheetRow['harga_satuan'],
            'notes' => $spreadsheetRow['catatan'],
        ]);
    }
}
