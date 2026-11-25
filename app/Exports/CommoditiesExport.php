<?php

namespace App\Exports;

use App\Models\Commodity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;

/**
 * Export commodity records with related attributes and condition labels.
 */
class CommoditiesExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, Commodity>
     */
    public function collection(): Collection
    {
        return Commodity::query()
            ->with([
                'brand:id,name',
                'commodityFundingSource:id,name',
                'commodityLocation:id,name',
                'material:id,name',
            ])
            ->orderBy('name')
            ->get()
            ->map(function (Commodity $commodity, int $index): Commodity {
                $commodity->row_number = $index + 1;

                return $commodity;
            });
    }

    /**
     * Define the export columns and their data types.
     *
     * @return list<Column>
     */
    public function columns(): array
    {
        return [
            Number::make('No', 'row_number'),
            Text::make('Kode Barang', 'item_code'),
            Text::make('Nama Barang', 'name'),
            Text::make('Merek', fn (Commodity $commodity): ?string => $commodity->brand?->name),
            Text::make('Bahan', fn (Commodity $commodity): ?string => $commodity->material?->name),
            Text::make('Ruangan', fn (Commodity $commodity): ?string => $commodity->commodityLocation?->name),
            Text::make('Sumber Perolehan', fn (Commodity $commodity): ?string => $commodity->commodityFundingSource?->name),
            Number::make('Tahun Perolehan', 'purchase_year'),
            Text::make('Kondisi', fn (Commodity $commodity): ?string => $commodity->condition?->label()),
            Number::make('Jumlah', 'quantity'),
            Number::make('Harga Satuan', 'unit_price'),
            Number::make('Total Harga', 'total_price'),
            Text::make('Catatan', 'notes'),
        ];
    }
}
