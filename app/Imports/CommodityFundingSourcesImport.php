<?php

namespace App\Imports;

use App\Models\CommodityFundingSource;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create funding source records from spreadsheet rows.
 */
class CommodityFundingSourcesImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Create a funding source from each imported row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     * @return Model|null
     */
    public function model(array $spreadsheetRow): ?Model
    {
        return new CommodityFundingSource([
            'name' => $spreadsheetRow['nama_perolehan'],
            'description' => $spreadsheetRow['deskripsi'],
        ]);
    }
}
