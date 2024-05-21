<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\CommodityLocation;
use App\Repositories\CommodityRepository;
use App\Repositories\SchoolOperationalAssistanceRepository;
use App\Services\CommodityService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        public CommodityRepository $commodityRepository,
        public SchoolOperationalAssistanceRepository $schoolOperationalAssistanceRepository
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
                'count' => $commodity->count
            ]);
        });

        $commodity_counts = [
            'commodity_in_total' => $commodity_condition_count->sum('count') ?? 0,
            'commodity_in_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Baik')['count'] ?? 0,
            'commodity_in_not_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Kurang Baik')['count'] ?? 0,
            'commodity_in_heavily_damage_condition' => $commodity_condition_count->firstWhere('condition_name', 'Rusak Berat')['count'] ?? 0
        ];

        $commodity_each_year_of_purchase_count = $this->commodityRepository->countCommodityEachYear();
        $commodity_each_location_count = CommodityLocation::has('commodities')->withCount('commodities')->get();
        $commodity_by_school_operational_assistance_count = $this->schoolOperationalAssistanceRepository
            ->countCommodityBySchoolOperationalAssistance();
        $commodity_by_material_count = $this->commodityRepository->countCommodityByMaterial()->map(function ($commodity) {
            return collect([
                'name' => $commodity->material,
                'material_count' => $commodity->count
            ]);
        });
        $commodity_by_brand_count = $this->commodityRepository->countCommodityByBrand()->map(function ($commodity) {
            return collect([
                'name' => $commodity->brand,
                'brand_count' => $commodity->count
            ]);
        });

        $charts = [
            'commodity_condition_count' => [
                'categories' => $commodity_condition_count->pluck('condition_name'),
                'series' => $commodity_condition_count->pluck('count')
            ],
            'commodity_each_year_of_purchase_count' => [
                'categories' => $commodity_each_year_of_purchase_count->pluck('year_of_purchase'),
                'series' => $commodity_each_year_of_purchase_count->pluck('count')
            ],
            'commodity_each_location_count' => [
                'categories' => $commodity_each_location_count->pluck('name'),
                'series' => $commodity_each_location_count->pluck('commodities_count')
            ],
            'commodity_by_school_operational_assistance_count' => [
                'categories' => $commodity_by_school_operational_assistance_count->pluck('name'),
                'series' => $commodity_by_school_operational_assistance_count->pluck('commodities_count')
            ],
            'commodity_by_material_count' => [
                'categories' => $commodity_by_material_count->pluck('name'),
                'series' => $commodity_by_material_count->pluck('material_count')
            ],
            'commodity_by_brand_count' => [
                'categories' => $commodity_by_brand_count->pluck('name'),
                'series' => $commodity_by_brand_count->pluck('brand_count')
            ]
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
