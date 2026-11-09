<?php

namespace App\Http\Controllers;

use App\Enums\CommodityCondition;
use App\Models\CommodityLocation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class CommodityLocationController extends Controller
{
    /**
     * Generate and stream a PDF document for all locations.
     */
    public function generateAllPdf(): Response
    {
        $locations = CommodityLocation::query()
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
            ->map(static fn (CommodityLocation $location): array => [
                $location->name,
                $location->description ?: '-',
                $location->commodities_count,
                $location->good_conditions_count,
                $location->poor_conditions_count,
                $location->heavily_damaged_conditions_count,
            ]);

        return Pdf::loadView('print.catalog', [
            'title' => 'Daftar Ruangan',
            'headers' => ['Nama Ruangan', 'Deskripsi', 'Total Barang', 'Kondisi Baik', 'Kurang Baik', 'Rusak Berat'],
            'rows' => $locations,
            'printedAt' => now()->translatedFormat('d F Y H:i'),
        ])
            ->setPaper('a4', 'landscape')
            ->stream('ruangan.pdf');
    }
}
