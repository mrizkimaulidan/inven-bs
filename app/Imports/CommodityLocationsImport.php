<?php

namespace App\Imports;

use App\Models\CommodityLocation;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create commodity location records from spreadsheet rows.
 */
class CommodityLocationsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Create a model from an imported row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     * @return Model|null
     */
    public function model(array $spreadsheetRow): ?Model
    {
        return new CommodityLocation([
            'name' => $spreadsheetRow['nama_ruangan'],
            'description' => $spreadsheetRow['deskripsi'] ?? null,
        ]);
    }
}
