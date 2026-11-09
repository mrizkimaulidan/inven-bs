<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CommodityCondition;
use App\Models\Commodity;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use LogicException;

class InventoryDashboardChartService
{
    private const TREND_MONTHS = 6;

    /**
     * @param  Builder<Commodity>  $query
     * @return array<string, mixed>
     */
    public function getChartData(Builder $query): array
    {
        $dimensions = [
            'location' => $this->groupDimension($query, 'commodity_locations', 'commodity_location_id'),
            'material' => $this->groupDimension($query, 'materials', 'material_id'),
            'brand' => $this->groupDimension($query, 'brands', 'brand_id'),
            'funding' => $this->groupDimension($query, 'commodity_funding_sources', 'commodity_funding_source_id'),
        ];
        $years = $this->groupPurchaseYears($query);
        $conditions = $this->groupConditions($query);
        $trends = $this->registrationTrends($query);

        return [
            'conditionDistribution' => $this->conditionRows($conditions, 'units'),
            'registrationTrend' => $trends['records'],
            'locationDistribution' => $this->pick($dimensions['location'], ['id', 'name', 'units'], 'units'),
            'materialDistribution' => $this->pick($dimensions['material'], ['id', 'name', 'units'], 'units'),
            'brandDistribution' => $this->pick($dimensions['brand'], ['id', 'name', 'units'], 'units'),
            'fundingSourceDistribution' => $this->pick($dimensions['funding'], ['id', 'name', 'value'], 'value'),
            'purchaseYearDistribution' => $this->pick($years, ['year', 'value']),
            'highestValueItems' => $this->highestValueItems($query),
            'locationValueDistribution' => $this->pick($dimensions['location'], ['id', 'name', 'value'], 'value'),
            'highestQuantityItems' => $this->highestQuantityItems($query),
            'conditionRecordDistribution' => $this->conditionRows($conditions, 'count'),
            'registrationUnitTrend' => $trends['units'],
            'monthlyInventoryValueTrend' => $trends['value'],
            'purchaseYearUnitDistribution' => $this->pick($years, ['year', 'units']),
            'locationRecordDistribution' => $this->pick($dimensions['location'], ['id', 'name', 'count'], 'count'),
            'materialRecordDistribution' => $this->pick($dimensions['material'], ['id', 'name', 'count'], 'count'),
            'brandRecordDistribution' => $this->pick($dimensions['brand'], ['id', 'name', 'count'], 'count'),
            'fundingSourceUnitDistribution' => $this->pick($dimensions['funding'], ['id', 'name', 'units'], 'units'),
            'fundingSourceRecordDistribution' => $this->pick($dimensions['funding'], ['id', 'name', 'count'], 'count'),
            'inventoryAgeDistribution' => $this->inventoryAgeRows($years),
            'conditionValueDistribution' => $this->conditionRows($conditions, 'totalValue'),
            'conditionAverageUnitPrice' => $this->conditionRows($conditions, 'averagePrice'),
            'averageUnitPriceByBrand' => $this->pick($dimensions['brand'], ['id', 'name', 'averagePrice'], 'averagePrice'),
            'brandAverageQuantityDistribution' => $this->pick($dimensions['brand'], ['id', 'name', 'averageUnits'], 'averageUnits'),
            'materialValueDistribution' => $this->pick($dimensions['material'], ['id', 'name', 'value'], 'value'),
            'averageUnitPriceByMaterial' => $this->pick($dimensions['material'], ['id', 'name', 'averagePrice'], 'averagePrice'),
            'averageCommodityValueByLocation' => $this->pick($dimensions['location'], ['id', 'name', 'averageValue'], 'averageValue'),
            'locationAverageQuantityDistribution' => $this->pick($dimensions['location'], ['id', 'name', 'averageUnits'], 'averageUnits'),
            'purchaseYearRecordDistribution' => $this->pick($years, ['year', 'count']),
            'fundingSourceAverageUnitPrice' => $this->pick($dimensions['funding'], ['id', 'name', 'averagePrice'], 'averagePrice'),
        ];
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return list<array<string, int|float|string>>
     */
    private function groupDimension(Builder $query, string $table, string $foreignKey): array
    {
        $rows = (clone $query)
            ->join($table, $table.'.id', '=', 'commodities.'.$foreignKey)
            ->select($table.'.id', $table.'.name')
            ->selectRaw(
                'COUNT(*) AS record_count, SUM(commodities.quantity) AS unit_count, SUM(commodities.total_price) AS inventory_value, AVG(commodities.unit_price) AS average_price, AVG(commodities.quantity) AS average_units, AVG(commodities.total_price) AS average_value',
            )
            ->groupBy($table.'.id', $table.'.name')
            ->get()
            ->map(static fn (object $row): array => [
                'id' => (int) $row->id,
                'name' => (string) $row->name,
                'units' => (int) $row->unit_count,
                'count' => (int) $row->record_count,
                'value' => (float) $row->inventory_value,
                'averagePrice' => (float) $row->average_price,
                'averageUnits' => (float) $row->average_units,
                'averageValue' => (float) $row->average_value,
            ])
            ->all();

        return $rows;
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return list<array<string, int|float>>
     */
    private function groupPurchaseYears(Builder $query): array
    {
        return (clone $query)
            ->select('commodities.purchase_year')
            ->selectRaw(
                'COUNT(*) AS record_count, SUM(commodities.quantity) AS unit_count, SUM(commodities.total_price) AS inventory_value',
            )
            ->groupBy('commodities.purchase_year')
            ->orderByDesc('commodities.purchase_year')
            ->get()
            ->map(static fn (object $row): array => [
                'year' => (int) $row->purchase_year,
                'count' => (int) $row->record_count,
                'units' => (int) $row->unit_count,
                'value' => (float) $row->inventory_value,
            ])
            ->all();
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return array<int, array{units: int, count: int, totalValue: float, averagePrice: float}>
     */
    private function groupConditions(Builder $query): array
    {
        return (clone $query)
            ->select('commodities.condition')
            ->selectRaw(
                'SUM(commodities.quantity) AS unit_count, COUNT(*) AS record_count, SUM(commodities.total_price) AS inventory_value, AVG(commodities.unit_price) AS average_price',
            )
            ->groupBy('commodities.condition')
            ->get()
            ->mapWithKeys(static function (object $row): array {
                $condition = $row->condition instanceof CommodityCondition
                    ? $row->condition->value
                    : (int) $row->condition;

                return [
                    $condition => [
                        'units' => (int) $row->unit_count,
                        'count' => (int) $row->record_count,
                        'totalValue' => (float) $row->inventory_value,
                        'averagePrice' => (float) $row->average_price,
                    ],
                ];
            })
            ->all();
    }

    /**
     * @param  array<int, array{units: int, count: int, totalValue: float, averagePrice: float}>  $conditions
     * @return list<array<string, int|float|string>>
     */
    private function conditionRows(array $conditions, string $metric): array
    {
        return array_map(
            static function (CommodityCondition $condition) use ($conditions, $metric): array {
                $row = $conditions[$condition->value] ?? [
                    'units' => 0,
                    'count' => 0,
                    'totalValue' => 0.0,
                    'averagePrice' => 0.0,
                ];

                return [
                    'value' => $condition->value,
                    'label' => $condition->label(),
                    $metric => $row[$metric],
                    ...($metric === 'units' ? ['variant' => match ($condition) {
                        CommodityCondition::GOOD => 'success',
                        CommodityCondition::POOR => 'warning',
                        CommodityCondition::HEAVILY_DAMAGED => 'danger',
                    }] : []),
                ];
            },
            CommodityCondition::cases(),
        );
    }

    /**
     * @param  list<array<string, int|float>>  $rows
     * @param  list<string>  $fields
     * @return list<array<string, int|float|string>>
     */
    private function pick(array $rows, array $fields, ?string $sortBy = null): array
    {
        if ($sortBy !== null) {
            usort($rows, static fn (array $first, array $second): int => $second[$sortBy] <=> $first[$sortBy]);
        }

        return array_map(
            static fn (array $row): array => array_intersect_key($row, array_flip($fields)),
            $rows,
        );
    }

    /**
     * @param  list<array<string, int|float>>  $years
     * @return list<array{label: string, value: float, units: int}>
     */
    private function inventoryAgeRows(array $years): array
    {
        $bands = [
            '0–2 tahun' => ['value' => 0.0, 'units' => 0],
            '3–5 tahun' => ['value' => 0.0, 'units' => 0],
            '6–10 tahun' => ['value' => 0.0, 'units' => 0],
            '>10 tahun' => ['value' => 0.0, 'units' => 0],
            'Tahun mendatang' => ['value' => 0.0, 'units' => 0],
        ];
        $currentYear = (int) now()->format('Y');

        foreach ($years as $year) {
            $age = $currentYear - $year['year'];
            $label = match (true) {
                $age < 0 => 'Tahun mendatang',
                $age <= 2 => '0–2 tahun',
                $age <= 5 => '3–5 tahun',
                $age <= 10 => '6–10 tahun',
                default => '>10 tahun',
            };
            $bands[$label]['value'] += $year['value'];
            $bands[$label]['units'] += $year['units'];
        }

        return array_map(
            static fn (string $label, array $values): array => ['label' => $label, ...$values],
            array_keys($bands),
            array_values($bands),
        );
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return array{
     *     records: array{labels: list<string>, values: list<int>},
     *     units: array{labels: list<string>, values: list<int>},
     *     value: array{labels: list<string>, values: list<float>}
     * }
     */
    private function registrationTrends(Builder $query): array
    {
        $monthExpression = match (DB::connection()->getDriverName()) {
            'sqlite' => "strftime('%Y-%m', commodities.created_at)",
            'mysql', 'mariadb' => "DATE_FORMAT(commodities.created_at, '%Y-%m')",
            'pgsql' => "TO_CHAR(commodities.created_at, 'YYYY-MM')",
            default => throw new LogicException('Unsupported database driver for inventory dashboard trend.'),
        };
        $firstMonth = CarbonImmutable::now()->startOfMonth()->subMonths(self::TREND_MONTHS - 1);
        $rowsByMonth = (clone $query)
            ->where('commodities.created_at', '>=', $firstMonth)
            ->selectRaw(
                $monthExpression.' AS month, COUNT(*) AS record_count, SUM(commodities.quantity) AS unit_count, SUM(commodities.total_price) AS inventory_value',
            )
            ->groupByRaw($monthExpression)
            ->get()
            ->keyBy('month');
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $labels = [];
        $records = [];
        $units = [];
        $values = [];

        for ($offset = 0; $offset < self::TREND_MONTHS; $offset++) {
            $month = $firstMonth->addMonths($offset);
            $row = $rowsByMonth->get($month->format('Y-m'));
            $labels[] = $monthNames[(int) $month->format('n') - 1].' '.$month->format('Y');
            $records[] = (int) ($row?->record_count ?? 0);
            $units[] = (int) ($row?->unit_count ?? 0);
            $values[] = (float) ($row?->inventory_value ?? 0);
        }

        return [
            'records' => ['labels' => $labels, 'values' => $records],
            'units' => ['labels' => $labels, 'values' => $units],
            'value' => ['labels' => $labels, 'values' => $values],
        ];
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return list<array{id: int, itemCode: string, name: string, value: float}>
     */
    private function highestValueItems(Builder $query): array
    {
        return (clone $query)
            ->select(['commodities.id', 'commodities.item_code', 'commodities.name', 'commodities.total_price'])
            ->orderByDesc('commodities.total_price')
            ->get()
            ->map(static fn (Commodity $item): array => [
                'id' => $item->id,
                'itemCode' => $item->item_code,
                'name' => $item->name,
                'value' => (float) $item->total_price,
            ])
            ->all();
    }

    /**
     * @param  Builder<Commodity>  $query
     * @return list<array{id: int, itemCode: string, name: string, units: int}>
     */
    private function highestQuantityItems(Builder $query): array
    {
        return (clone $query)
            ->select(['commodities.id', 'commodities.item_code', 'commodities.name', 'commodities.quantity'])
            ->orderByDesc('commodities.quantity')
            ->get()
            ->map(static fn (Commodity $item): array => [
                'id' => $item->id,
                'itemCode' => $item->item_code,
                'name' => $item->name,
                'units' => (int) $item->quantity,
            ])
            ->all();
    }
}
