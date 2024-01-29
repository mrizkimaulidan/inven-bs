<?php

namespace App\Http\Controllers;

use App\Commodity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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

        $commodity_condition_count = Commodity::selectRaw('`condition`, COUNT(`condition`) AS count')
            ->groupBy('condition')
            ->get()
            ->map(function ($item) {
                return collect([
                    'condition_name' => $item->getConditionName(),
                    'count' => $item->count
                ]);
            });

        $commodity_condition_count_chart = [
            'categories' => $commodity_condition_count->pluck('condition_name'),
            'series' => $commodity_condition_count->pluck('count'),
        ];

        return view(
            'home',
            compact(
                'commodity_order_by_price',
                'commodity_count',
                'commodity_condition_good_count',
                'commodity_condition_not_good_count',
                'commodity_condition_heavily_damage_count',
                'commodity_condition_count_chart'
            )
        );
    }
}
