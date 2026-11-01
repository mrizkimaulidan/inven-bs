<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create brand records from spreadsheet rows.
 */
class BrandsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Create a brand from an imported row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     * @return Model|null
     */
    public function model(array $spreadsheetRow): ?Model
    {
        $brandName = trim((string) ($spreadsheetRow['nama_merek'] ?? ''));

        if ($brandName === '') {
            throw new InvalidArgumentException('Kolom Nama Merek wajib diisi.');
        }

        return new Brand(['name' => $brandName]);
    }
}
