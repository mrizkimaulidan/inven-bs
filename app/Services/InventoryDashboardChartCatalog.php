<?php

declare(strict_types=1);

namespace App\Services;

class InventoryDashboardChartCatalog
{
    private const DEFINITIONS = [
        'registrationTrend' => ['title' => 'Tren Pencatatan Barang', 'description' => 'Jumlah data barang baru yang dicatat setiap bulan.', 'id' => 'registrationTrendChart', 'type' => 'line', 'dataset' => 'Barang tercatat', 'unit' => 'data barang', 'format' => 'number', 'color' => 'primary', 'trend' => true, 'column' => 'col-lg-8 col-12', 'height' => 120],
        'conditionDistribution' => ['title' => 'Distribusi Kondisi Barang', 'description' => 'Komposisi unit berdasarkan kondisi saat ini.', 'id' => 'conditionDistributionChart', 'type' => 'doughnut', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'palette', 'label' => 'label', 'metric' => 'units', 'column' => 'col-lg-4 col-12'],
        'locationDistribution' => ['title' => 'Distribusi Unit per Lokasi', 'description' => 'Seluruh lokasi diurutkan berdasarkan jumlah unit.', 'id' => 'locationDistributionChart', 'type' => 'bar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'primary', 'metric' => 'units'],
        'materialDistribution' => ['title' => 'Distribusi Unit per Bahan', 'description' => 'Komposisi unit barang untuk seluruh bahan.', 'id' => 'materialDistributionChart', 'type' => 'bar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'info', 'metric' => 'units'],
        'brandDistribution' => ['title' => 'Distribusi Unit per Merek', 'description' => 'Perbandingan jumlah unit untuk seluruh merek.', 'id' => 'brandDistributionChart', 'type' => 'bar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'success', 'metric' => 'units'],
        'fundingSourceDistribution' => ['title' => 'Nilai Inventaris per Sumber Dana', 'description' => 'Nilai aset untuk seluruh sumber dana.', 'id' => 'fundingSourceDistributionChart', 'type' => 'horizontalBar', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'palette', 'metric' => 'value'],
        'purchaseYearDistribution' => ['title' => 'Nilai Inventaris per Tahun Pembelian', 'description' => 'Nilai aset dikelompokkan berdasarkan tahun pembelian.', 'id' => 'purchaseYearDistributionChart', 'type' => 'bar', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'warning', 'label' => 'year', 'metric' => 'value'],
        'highestValueItems' => ['title' => 'Barang dengan Nilai Tertinggi', 'description' => 'Seluruh data barang diurutkan berdasarkan nilai aset.', 'id' => 'highestValueItemsChart', 'type' => 'horizontalBar', 'dataset' => 'Nilai barang', 'format' => 'currency', 'color' => 'success', 'metric' => 'value', 'item' => true],
        'locationValueDistribution' => ['title' => 'Nilai Inventaris per Lokasi', 'description' => 'Total nilai aset untuk setiap lokasi.', 'id' => 'locationValueDistributionChart', 'type' => 'bar', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'primary', 'metric' => 'value'],
        'highestQuantityItems' => ['title' => 'Barang dengan Unit Terbanyak', 'description' => 'Seluruh data barang diurutkan berdasarkan jumlah unit.', 'id' => 'highestQuantityItemsChart', 'type' => 'horizontalBar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'info', 'metric' => 'units', 'item' => true],
        'conditionRecordDistribution' => ['title' => 'Jumlah Data per Kondisi', 'description' => 'Jumlah data barang untuk setiap kondisi.', 'id' => 'conditionRecordDistributionChart', 'type' => 'bar', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'palette', 'label' => 'label', 'metric' => 'count'],
        'registrationUnitTrend' => ['title' => 'Tren Unit Barang Baru', 'description' => 'Jumlah unit yang dicatat setiap bulan.', 'id' => 'registrationUnitTrendChart', 'type' => 'line', 'dataset' => 'Unit tercatat', 'unit' => 'unit', 'format' => 'number', 'color' => 'info', 'trend' => true],
        'monthlyInventoryValueTrend' => ['title' => 'Nilai Barang yang Dicatat per Bulan', 'description' => 'Nilai inventaris yang dicatat setiap bulan.', 'id' => 'monthlyInventoryValueTrendChart', 'type' => 'line', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'success', 'trend' => true],
        'purchaseYearUnitDistribution' => ['title' => 'Jumlah Unit per Tahun Pembelian', 'description' => 'Jumlah unit barang untuk setiap tahun pembelian.', 'id' => 'purchaseYearUnitDistributionChart', 'type' => 'bar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'primary', 'label' => 'year', 'metric' => 'units'],
        'locationRecordDistribution' => ['title' => 'Jumlah Data per Lokasi', 'description' => 'Jumlah data barang untuk seluruh lokasi.', 'id' => 'locationRecordDistributionChart', 'type' => 'horizontalBar', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'primary', 'metric' => 'count'],
        'materialRecordDistribution' => ['title' => 'Jumlah Data per Bahan', 'description' => 'Jumlah data barang untuk seluruh bahan.', 'id' => 'materialRecordDistributionChart', 'type' => 'pie', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'palette', 'metric' => 'count'],
        'brandRecordDistribution' => ['title' => 'Jumlah Data per Merek', 'description' => 'Jumlah data barang untuk seluruh merek.', 'id' => 'brandRecordDistributionChart', 'type' => 'polarArea', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'palette', 'metric' => 'count'],
        'fundingSourceUnitDistribution' => ['title' => 'Unit per Sumber Dana', 'description' => 'Jumlah unit barang untuk seluruh sumber dana.', 'id' => 'fundingSourceUnitDistributionChart', 'type' => 'bar', 'dataset' => 'Jumlah unit', 'unit' => 'unit', 'format' => 'number', 'color' => 'palette', 'metric' => 'units'],
        'fundingSourceRecordDistribution' => ['title' => 'Jumlah Data per Sumber Dana', 'description' => 'Jumlah data barang untuk seluruh sumber dana.', 'id' => 'fundingSourceRecordDistributionChart', 'type' => 'horizontalBar', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'warning', 'metric' => 'count'],
        'inventoryAgeDistribution' => ['title' => 'Nilai Inventaris berdasarkan Usia', 'description' => 'Nilai aset berdasarkan jarak tahun pembelian dengan tahun berjalan.', 'id' => 'inventoryAgeDistributionChart', 'type' => 'doughnut', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'palette', 'label' => 'label', 'metric' => 'value'],
        'conditionValueDistribution' => ['title' => 'Nilai Inventaris per Kondisi', 'description' => 'Total nilai aset untuk setiap kondisi barang.', 'id' => 'conditionValueDistributionChart', 'type' => 'pie', 'dataset' => 'Nilai inventaris', 'format' => 'currency', 'color' => 'palette', 'label' => 'label', 'metric' => 'totalValue'],
        'conditionAverageUnitPrice' => ['title' => 'Rata-rata Harga Satuan per Kondisi', 'description' => 'Rata-rata harga per unit untuk setiap kondisi barang.', 'id' => 'conditionAverageUnitPriceChart', 'type' => 'bar', 'dataset' => 'Rata-rata harga satuan', 'format' => 'currency', 'color' => 'warning', 'label' => 'label', 'metric' => 'averagePrice'],
        'averageUnitPriceByBrand' => ['title' => 'Rata-rata Harga Satuan per Merek', 'description' => 'Rata-rata biaya per unit untuk seluruh merek.', 'id' => 'averageUnitPriceByBrandChart', 'type' => 'bar', 'dataset' => 'Rata-rata harga satuan', 'format' => 'currency', 'color' => 'info', 'metric' => 'averagePrice'],
        'brandAverageQuantityDistribution' => ['title' => 'Rata-rata Unit per Data Barang menurut Merek', 'description' => 'Rata-rata kuantitas setiap jenis barang untuk seluruh merek.', 'id' => 'brandAverageQuantityDistributionChart', 'type' => 'horizontalBar', 'dataset' => 'Rata-rata unit per data', 'unit' => 'unit per data', 'format' => 'decimal', 'color' => 'palette', 'metric' => 'averageUnits'],
        'materialValueDistribution' => ['title' => 'Nilai Inventaris per Bahan', 'description' => 'Total nilai barang dikelompokkan berdasarkan bahan.', 'id' => 'materialValueDistributionChart', 'type' => 'doughnut', 'dataset' => 'Nilai total aset', 'format' => 'currency', 'color' => 'palette', 'metric' => 'value'],
        'averageUnitPriceByMaterial' => ['title' => 'Rata-rata Harga Satuan per Bahan', 'description' => 'Perbandingan rata-rata biaya per unit untuk setiap bahan.', 'id' => 'averageUnitPriceByMaterialChart', 'type' => 'bar', 'dataset' => 'Rata-rata harga satuan', 'format' => 'currency', 'color' => 'success', 'metric' => 'averagePrice'],
        'averageCommodityValueByLocation' => ['title' => 'Rata-rata Nilai Data Barang per Lokasi', 'description' => 'Rata-rata nilai per jenis barang, bukan total nilai lokasi.', 'id' => 'averageCommodityValueByLocationChart', 'type' => 'horizontalBar', 'dataset' => 'Rata-rata nilai barang', 'format' => 'currency', 'color' => 'primary', 'metric' => 'averageValue'],
        'locationAverageQuantityDistribution' => ['title' => 'Rata-rata Unit per Data Barang menurut Lokasi', 'description' => 'Rata-rata kuantitas dalam satu data barang pada tiap lokasi.', 'id' => 'locationAverageQuantityDistributionChart', 'type' => 'horizontalBar', 'dataset' => 'Rata-rata unit per data', 'unit' => 'unit per data', 'format' => 'decimal', 'color' => 'info', 'metric' => 'averageUnits'],
        'purchaseYearRecordDistribution' => ['title' => 'Jumlah Data Barang per Tahun Pembelian', 'description' => 'Jumlah jenis barang yang dibeli setiap tahun.', 'id' => 'purchaseYearRecordDistributionChart', 'type' => 'bar', 'dataset' => 'Data barang', 'unit' => 'data barang', 'format' => 'number', 'color' => 'primary', 'label' => 'year', 'metric' => 'count'],
        'fundingSourceAverageUnitPrice' => ['title' => 'Rata-rata Harga Satuan per Sumber Dana', 'description' => 'Membandingkan biaya per unit menurut sumber dana.', 'id' => 'fundingSourceAverageUnitPriceChart', 'type' => 'polarArea', 'dataset' => 'Rata-rata harga satuan', 'format' => 'currency', 'color' => 'palette', 'metric' => 'averagePrice'],
    ];

    /**
     * Convert aggregated dashboard series into the presentation data shared by Blade and Chart.js.
     *
     * @param  array<string, mixed>  $data
     * @return list<array<string, mixed>>
     */
    public function build(array $data): array
    {
        $charts = [];

        foreach (self::DEFINITIONS as $key => $definition) {
            $series = $data[$key];
            $isTrend = $definition['trend'] ?? false;
            $labels = $isTrend
                ? $series['labels']
                : array_map(
                    fn (array $row): string => ($definition['item'] ?? false)
                        ? $row['itemCode'].' — '.$row['name']
                        : (string) $row[$definition['label'] ?? 'name'],
                    $series,
                );
            $values = $isTrend
                ? $series['values']
                : array_map(
                    fn (array $row): int|float => $row[$definition['metric']],
                    $series,
                );

            $charts[] = [
                'key' => $key,
                'title' => $definition['title'],
                'description' => $definition['description'],
                'chartLabel' => 'Grafik '.$definition['title'],
                'canvasId' => $definition['id'],
                'type' => $definition['type'],
                'datasetLabel' => $definition['dataset'],
                'unitLabel' => $definition['unit'] ?? null,
                'valueFormat' => $definition['format'],
                'color' => $definition['color'],
                'height' => $definition['height'] ?? 180,
                'columnClass' => $definition['column'] ?? 'col-lg-6 col-12',
                'labels' => $labels,
                'values' => $values,
                'variants' => $key === 'conditionDistribution'
                    ? array_column($series, 'variant')
                    : [],
            ];
        }

        return $charts;
    }
}
