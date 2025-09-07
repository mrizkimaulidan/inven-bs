<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\CommodityLocation;
use App\Repositories\CommodityAcquisitionRepository;
use App\Repositories\CommodityRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        public CommodityRepository $commodityRepository,
        public CommodityAcquisitionRepository $commodityAcquisitionRepository
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $commodity_order_by_price = Commodity::orderBy('price', 'DESC')->take(5)->get();
        $commodity_condition_count = $this->commodityRepository->countCommodityCondition()->map(function ($commodity) {
            return collect([
                'condition_name' => $commodity->getConditionName(),
                'count' => $commodity->count,
            ]);
        });

        $commodity_counts = [
            'commodity_in_total' => $commodity_condition_count->sum('count') ?? 0,
            'commodity_in_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Baik')['count'] ?? 0,
            'commodity_in_not_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Kurang Baik')['count'] ?? 0,
            'commodity_in_heavily_damage_condition' => $commodity_condition_count->firstWhere('condition_name', 'Rusak Berat')['count'] ?? 0,
        ];

        $commodity_each_year_of_purchase_count = $this->commodityRepository->countCommodityEachYear();
        $commodity_each_location_count = CommodityLocation::has('commodities')->withCount('commodities')->get();
        $commodity_by_commodity_acquisition_count = $this->commodityAcquisitionRepository
            ->countCommodityByCommodityAcquisition();
        $commodity_by_material_count = $this->commodityRepository->countCommodityByMaterial()->map(function ($commodity) {
            return collect([
                'name' => $commodity->material,
                'material_count' => $commodity->count,
            ]);
        });
        $commodity_by_brand_count = $this->commodityRepository->countCommodityByBrand()->map(function ($commodity) {
            return collect([
                'name' => $commodity->brand,
                'brand_count' => $commodity->count,
            ]);
        });

        $commodity_condition_by_location = $this->commodityRepository->countCommodityConditionByLocation()
            ->map(fn ($item) => [
                'location' => $item->commodity_location->name,
                'condition_name' => $item->getConditionName(),
                'count' => $item->count,
            ]);

        $commodity_locations = $commodity_condition_by_location->pluck('location')->unique()->values();

        $series = $commodity_condition_by_location
            ->groupBy('condition_name')
            ->map(function ($items, $conditionName) use ($commodity_locations) {
                $locationCounts = $items->groupBy('location')->map->sum('count');

                $data = $commodity_locations->map(fn ($location) => $locationCounts->get($location, 0));

                return ['name' => $conditionName, 'data' => $data];
            })
            ->values();

        $charts = [
            'commodity_condition_count' => [
                'categories' => $commodity_condition_count->pluck('condition_name'),
                'series' => $commodity_condition_count->pluck('count'),
            ],
            'commodity_each_year_of_purchase_count' => [
                'categories' => $commodity_each_year_of_purchase_count->pluck('year_of_purchase'),
                'series' => $commodity_each_year_of_purchase_count->pluck('count'),
            ],
            'commodity_each_location_count' => [
                'categories' => $commodity_each_location_count->pluck('name'),
                'series' => $commodity_each_location_count->pluck('commodities_count'),
            ],
            'commodity_by_commodity_acquisition_count' => [
                'categories' => $commodity_by_commodity_acquisition_count->pluck('name'),
                'series' => $commodity_by_commodity_acquisition_count->pluck('commodities_count'),
            ],
            'commodity_by_material_count' => [
                'categories' => $commodity_by_material_count->pluck('name'),
                'series' => $commodity_by_material_count->pluck('material_count'),
            ],
            'commodity_by_brand_count' => [
                'categories' => $commodity_by_brand_count->pluck('name'),
                'series' => $commodity_by_brand_count->pluck('brand_count'),
            ],
            'commodity_condition_by_location' => [
                'categories' => $commodity_locations,
                'series' => $series,
            ],
        ];

        return view(
            'home',
            compact(
                'commodity_order_by_price',
                'commodity_counts',
                'charts'
            )
        );
    }
}
