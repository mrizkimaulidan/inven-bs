<?php

namespace App\Http\Controllers;

use App\Enums\CommodityCondition;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF reporting actions for material records.
 */
class MaterialController extends Controller
{
    /**
     * Generate and stream a PDF document containing all materials and commodity counts.
     */
    public function generateAllPdf(): Response
    {
        $rows = Material::query()
            ->select(['id', 'name'])
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query): Builder => $query
                    ->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query): Builder => $query
                    ->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query): Builder => $query
                    ->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->orderBy('name')
            ->get()
            ->map(static fn (Material $material): array => [
                $material->name,
                $material->commodities_count,
                $material->good_conditions_count,
                $material->poor_conditions_count,
                $material->heavily_damaged_conditions_count,
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Bahan',
            'headers' => [
                'Nama Bahan',
                'Total Barang',
                CommodityCondition::GOOD->label(),
                CommodityCondition::POOR->label(),
                CommodityCondition::HEAVILY_DAMAGED->label(),
            ],
            'rows' => $rows,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('bahan.pdf');
    }
}
