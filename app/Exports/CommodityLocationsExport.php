<?php

namespace App\Exports;

use App\Enums\CommodityCondition;
use App\Models\CommodityLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;

/**
 * Export commodity location records along with commodity condition counts.
 */
class CommodityLocationsExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, CommodityLocation>
     */
    public function collection(): Collection
    {
        return CommodityLocation::query()
            ->select(['id', 'name', 'description'])
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query): Builder => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query): Builder => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query): Builder => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->orderBy('name')
            ->get()
            ->map(function (CommodityLocation $location, int $index): CommodityLocation {
                $location->row_number = $index + 1;

                return $location;
            });
    }

    /**
     * Define the export columns and their data types.
     *
     * @return list<Column>
     */
    public function columns(): array
    {
        $conditionPrefix = 'Kondisi';

        return [
            Number::make('No', 'row_number'),
            Text::make('Nama Ruangan', 'name'),
            Text::make('Deskripsi', 'description'),
            Number::make('Total Barang', 'commodities_count'),
            Number::make($conditionPrefix.' '.CommodityCondition::GOOD->label(), 'good_conditions_count'),
            Number::make($conditionPrefix.' '.CommodityCondition::POOR->label(), 'poor_conditions_count'),
            Number::make($conditionPrefix.' '.CommodityCondition::HEAVILY_DAMAGED->label(), 'heavily_damaged_conditions_count'),
        ];
    }
}
