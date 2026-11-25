<?php

namespace App\Http\Controllers;

use App\Enums\CommodityCondition;
use App\Models\CommodityFundingSource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF reporting actions for commodity funding source records.
 */
class CommodityFundingSourceController extends Controller
{
    /**
     * Generate and stream a PDF document containing all funding sources and commodity counts.
     */
    public function generateAllPdf(): Response
    {
        $rows = CommodityFundingSource::query()
            ->select(['id', 'name', 'description'])
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
            ->map(static fn (CommodityFundingSource $source): array => [
                $source->name,
                $source->description ?: '-',
                $source->commodities_count,
                $source->good_conditions_count,
                $source->poor_conditions_count,
                $source->heavily_damaged_conditions_count,
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Perolehan',
            'headers' => [
                'Nama Perolehan',
                'Deskripsi',
                'Total Barang',
                CommodityCondition::GOOD->label(),
                CommodityCondition::POOR->label(),
                CommodityCondition::HEAVILY_DAMAGED->label(),
            ],
            'rows' => $rows,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('perolehan.pdf');
    }
}
