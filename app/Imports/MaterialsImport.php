<?php

namespace App\Imports;

use App\Models\Material;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create material records from spreadsheet rows.
 */
class MaterialsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Build a material model instance from an imported spreadsheet row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     */
    public function model(array $spreadsheetRow): ?Material
    {
        $materialName = trim((string) ($spreadsheetRow['nama_bahan'] ?? ''));

        if ($materialName === '') {
            throw new InvalidArgumentException('Kolom Nama Bahan wajib diisi.');
        }

        return new Material([
            'name' => $materialName,
        ]);
    }
}
