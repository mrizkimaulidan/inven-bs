<?php

namespace App\Imports;

use App\Models\Brand;
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
     * Build a brand model instance from an imported spreadsheet row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     */
    public function model(array $spreadsheetRow): ?Brand
    {
        $brandName = trim((string) ($spreadsheetRow['nama_merek'] ?? ''));

        if ($brandName === '') {
            throw new InvalidArgumentException('Kolom Nama Merek wajib diisi.');
        }

        return new Brand([
            'name' => $brandName,
        ]);
    }
}
