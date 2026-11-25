<?php

namespace App\Imports;

use App\Models\CommodityLocation;
use InvalidArgumentException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Create commodity location records from spreadsheet rows.
 */
class CommodityLocationsImport implements SkipsEmptyRows, ToModel, WithHeadingRow
{
    /**
     * Build a commodity location model instance from an imported spreadsheet row.
     *
     * @param  array<string, mixed>  $spreadsheetRow
     */
    public function model(array $spreadsheetRow): ?CommodityLocation
    {
        $name = trim((string) ($spreadsheetRow['nama_ruangan'] ?? ''));

        if ($name === '') {
            throw new InvalidArgumentException('Kolom Nama Ruangan wajib diisi.');
        }

        $description = isset($spreadsheetRow['deskripsi'])
            ? trim((string) $spreadsheetRow['deskripsi'])
            : null;

        return new CommodityLocation([
            'name' => $name,
            'description' => $description !== '' ? $description : null,
        ]);
    }
}
