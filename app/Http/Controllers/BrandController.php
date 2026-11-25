<?php

namespace App\Http\Controllers;

use App\Enums\CommodityCondition;
use App\Models\Brand;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF reporting actions for brand records.
 */
class BrandController extends Controller
{
    /**
     * Generate and stream a PDF document containing all brands and commodity counts.
     */
    public function generateAllPdf(): Response
    {
        $rows = Brand::query()
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
            ->map(static fn (Brand $brand): array => [
                $brand->name,
                $brand->commodities_count,
                $brand->good_conditions_count,
                $brand->poor_conditions_count,
                $brand->heavily_damaged_conditions_count,
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Merek',
            'headers' => [
                'Nama Merek',
                'Total Barang',
                CommodityCondition::GOOD->label(),
                CommodityCondition::POOR->label(),
                CommodityCondition::HEAVILY_DAMAGED->label(),
            ],
            'rows' => $rows,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('merek.pdf');
    }
}
