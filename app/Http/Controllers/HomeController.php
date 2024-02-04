<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\Repositories\CommodityRepository;
use App\Services\CommodityService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        public CommodityRepository $commodityRepository
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
        $commodity_count = Commodity::count();

        $commodity_condition_good_count = Commodity::where('condition', 1)->count();
        $commodity_condition_not_good_count = Commodity::where('condition', 2)->count();
        $commodity_condition_heavily_damage_count = Commodity::where('condition', 3)->count();

        $commodity_order_by_price = Commodity::orderBy('price', 'DESC')->take(5)->get();

        $commodity_condition_count = $this->commodityRepository->countCommodityCondition()->map(function ($commodity) {
            return collect([
                'condition_name' => $commodity->getConditionName(),
                'count' => $commodity->count
            ]);
        });

        $commodity_each_year_of_purchase_count = $this->commodityRepository->countCommodityEachYear();

        $charts = [
            'commodity_condition_count' => [
                'categories' => $commodity_condition_count->pluck('condition_name'),
                'series' => $commodity_condition_count->pluck('count')
            ],
            'commodity_each_year_of_purchase_count' => [
                'categories' => $commodity_each_year_of_purchase_count->pluck('year_of_purchase'),
                'series' => $commodity_each_year_of_purchase_count->pluck('count')
            ]
        ];

        return view(
            'home',
            compact(
                'commodity_order_by_price',
                'commodity_count',
                'commodity_condition_good_count',
                'commodity_condition_not_good_count',
                'commodity_condition_heavily_damage_count',
                'charts'
            )
        );
    }
}
