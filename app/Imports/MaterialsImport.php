<?php

namespace App\Imports;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create material records from spreadsheet rows.
 */
class MaterialsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Create a material from an imported row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     * @return Model|null
     */
    public function model(array $spreadsheetRow): ?Model
    {
        return new Material(['name' => $spreadsheetRow['nama_bahan']]);
    }
}
