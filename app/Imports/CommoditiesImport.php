<?php

namespace App\Imports;

use App\Enums\CommodityCondition;
use App\Models\Commodity;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create commodity records from spreadsheet rows with default foreign keys.
 */
class CommoditiesImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Build a commodity model instance from an imported spreadsheet row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     */
    public function model(array $spreadsheetRow): ?Commodity
    {
        $conditionLabel = trim((string) ($spreadsheetRow['kondisi'] ?? ''));
        $condition = CommodityCondition::fromLabel($conditionLabel);

        if ($condition === null) {
            throw new InvalidArgumentException("Nilai kondisi '{$conditionLabel}' tidak valid.");
        }

        $quantity = (int) ($spreadsheetRow['jumlah'] ?? 0);
        $unitPrice = (float) ($spreadsheetRow['harga_satuan'] ?? 0);
        $actorId = auth()->id() ?? 1;

        return new Commodity([
            'commodity_funding_source_id' => 1,
            'commodity_location_id' => 1,
            'created_by' => $actorId,
            'updated_by' => $actorId,
            'brand_id' => 1,
            'material_id' => 1,
            'item_code' => trim((string) ($spreadsheetRow['kode_barang'] ?? '')),
            'qr_code' => (string) Str::ulid(),
            'name' => trim((string) ($spreadsheetRow['nama_barang'] ?? '')),
            'purchase_year' => (int) ($spreadsheetRow['tahun_pembelian'] ?? now()->year),
            'condition' => $condition,
            'image' => 'img/products/product-1.jpg',
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $quantity * $unitPrice,
            'notes' => isset($spreadsheetRow['catatan']) ? trim((string) $spreadsheetRow['catatan']) : null,
        ]);
    }
}
