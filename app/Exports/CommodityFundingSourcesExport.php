<?php

namespace App\Exports;

use App\Enums\CommodityCondition;
use App\Models\CommodityFundingSource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;

/**
 * Build spreadsheet columns for exporting funding source records.
 */
class CommodityFundingSourcesExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, CommodityFundingSource>
     */
    public function collection(): Collection
    {
        return CommodityFundingSource::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'description'])
            ->values()
            ->map(function (CommodityFundingSource $fundingSource, int $index) {
                $fundingSource->row_number = $index + 1;

                return $fundingSource;
            });
    }

    /**
     * Define the columns and their data types.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Number::make('No', 'row_number'),
            Text::make('Nama Perolehan', 'name'),
            Text::make('Deskripsi', 'description'),
            Number::make('Total Barang', 'commodities_count'),
            Number::make('Kondisi Baik', 'good_conditions_count'),
            Number::make('Kondisi Kurang Baik', 'poor_conditions_count'),
            Number::make('Kondisi Rusak Berat', 'heavily_damaged_conditions_count'),
        ];
    }
}
