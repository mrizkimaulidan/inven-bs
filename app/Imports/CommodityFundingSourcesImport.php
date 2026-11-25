<?php

namespace App\Imports;

use App\Models\CommodityFundingSource;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create commodity funding source records from spreadsheet rows.
 */
class CommodityFundingSourcesImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Build a commodity funding source model instance from an imported spreadsheet row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     */
    public function model(array $spreadsheetRow): ?CommodityFundingSource
    {
        $name = trim((string) ($spreadsheetRow['nama_perolehan'] ?? ''));

        if ($name === '') {
            throw new InvalidArgumentException('Kolom Nama Perolehan wajib diisi.');
        }

        $description = isset($spreadsheetRow['deskripsi'])
            ? trim((string) $spreadsheetRow['deskripsi'])
            : null;

        return new CommodityFundingSource([
            'name' => $name,
            'description' => $description !== '' ? $description : null,
        ]);
    }
}
