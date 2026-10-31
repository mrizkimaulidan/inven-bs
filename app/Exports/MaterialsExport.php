<?php

namespace App\Exports;

use App\Enums\CommodityCondition;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Columns\Column;
use Maatwebsite\Excel\Columns\Number;
use Maatwebsite\Excel\Columns\Text;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumns;

class MaterialsExport implements FromCollection, WithColumns
{
    use Exportable;

    /**
     * Retrieve the data source for the export.
     *
     * @return Collection<int, Material>
     */
    public function collection(): Collection
    {
        return Material::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->orderBy('name')
            ->get(['id', 'name'])
            ->values()
            ->map(function (Material $material, int $index) {
                $material->row_number = $index + 1;

                return $material;
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
            Text::make('Nama Bahan', 'name'),
            Number::make('Total Barang', 'commodities_count'),
            Number::make('Kondisi Baik', 'good_conditions_count'),
            Number::make('Kondisi Kurang Baik', 'poor_conditions_count'),
            Number::make('Kondisi Rusak Berat', 'heavily_damaged_conditions_count'),
        ];
    }
}
