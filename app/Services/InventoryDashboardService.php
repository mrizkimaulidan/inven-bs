<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CommodityCondition;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityLocation;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Orchestrate filtered inventory queries, dashboard summary metrics, filter options, and chart payloads.
 */
class InventoryDashboardService
{
    public function __construct(
        private readonly InventoryDashboardChartService $chartService,
        private readonly InventoryDashboardChartCatalog $chartCatalog,
    ) {}

    /**
     * Build dashboard summary cards, chart datasets, and recent commodities for the given filters.
     *
     * @param  array{search: string, brandId: string, materialId: string, locationId: string, condition: string, purchaseYear: string}  $filters
     * @return array<string, mixed>
     */
    public function getDashboardData(array $filters): array
    {
        $query = $this->filteredQuery($filters);
        $summary = (clone $query)
            ->selectRaw(
                'COUNT(*) AS total_items, COALESCE(SUM(commodities.quantity), 0) AS total_units, COALESCE(SUM(commodities.total_price), 0) AS inventory_value',
            )
            ->first();
        $chartData = $this->chartService->getChartData(clone $query);

        return [
            'summary' => [
                'totalItems' => (int) ($summary?->total_items ?? 0),
                'totalUnits' => (int) ($summary?->total_units ?? 0),
                'inventoryValue' => (float) ($summary?->inventory_value ?? 0.0),
                'totalLocations' => (int) (clone $query)
                    ->distinct()
                    ->count('commodities.commodity_location_id'),
            ],
            ...$chartData,
            'charts' => $this->chartCatalog->build($chartData),
            'recentItems' => (clone $query)
                ->with(['brand', 'material', 'commodityLocation'])
                ->latest('commodities.created_at')
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Retrieve available filter options for the inventory dashboard.
     *
     * @return array{brands: Collection<int, Brand>, materials: Collection<int, Material>, locations: Collection<int, CommodityLocation>, conditions: array<int, string>, purchaseYears: list<string>}
     */
    public function getFilterOptions(): array
    {
        return [
            'brands' => Brand::query()->orderBy('name')->get(['id', 'name']),
            'materials' => Material::query()->orderBy('name')->get(['id', 'name']),
            'locations' => CommodityLocation::query()->orderBy('name')->get(['id', 'name']),
            'conditions' => CommodityCondition::options(),
            'purchaseYears' => Commodity::query()
                ->distinct()
                ->orderByDesc('purchase_year')
                ->pluck('purchase_year')
                ->map(static fn (int|string $year): string => (string) $year)
                ->all(),
        ];
    }

    /**
     * Build a filtered Eloquent query for commodities based on active dashboard filters.
     *
     * @param  array{search: string, brandId: string, materialId: string, locationId: string, condition: string, purchaseYear: string}  $filters
     * @return Builder<Commodity>
     */
    private function filteredQuery(array $filters): Builder
    {
        $search = trim($filters['search']);

        return Commodity::query()
            ->when(
                $search !== '',
                static fn (Builder $query): Builder => $query->where(static function (Builder $query) use ($search): void {
                    $query
                        ->where('commodities.item_code', 'like', '%'.$search.'%')
                        ->orWhere('commodities.name', 'like', '%'.$search.'%');
                }),
            )
            ->when(
                $filters['brandId'] !== '',
                static fn (Builder $query): Builder => $query->where('commodities.brand_id', (int) $filters['brandId']),
            )
            ->when(
                $filters['materialId'] !== '',
                static fn (Builder $query): Builder => $query->where('commodities.material_id', (int) $filters['materialId']),
            )
            ->when(
                $filters['locationId'] !== '',
                static fn (Builder $query): Builder => $query->where(
                    'commodities.commodity_location_id',
                    (int) $filters['locationId'],
                ),
            )
            ->when(
                $filters['condition'] !== '',
                static fn (Builder $query): Builder => $query->where(
                    'commodities.condition',
                    (int) $filters['condition'],
                ),
            )
            ->when(
                $filters['purchaseYear'] !== '',
                static fn (Builder $query): Builder => $query->where(
                    'commodities.purchase_year',
                    (int) $filters['purchaseYear'],
                ),
            );
    }
}
