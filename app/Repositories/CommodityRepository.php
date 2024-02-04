<?php

namespace App\Repositories;

use App\Commodity;

class CommodityRepository
{
    public function __construct(
        private Commodity $model
    ) {
    }

    /**
     * Count commodities based on different conditions.
     */
    public function countCommodityCondition()
    {
        return $this->model->selectRaw('`condition`, COUNT(`condition`) AS count')
            ->groupBy('condition')
            ->get();
    }

    /**
     * Count commodities for each year of purchase.
     */
    public function countCommodityEachYear()
    {
        return $this->model->selectRaw('COUNT(`year_of_purchase`) AS count, year_of_purchase')
            ->groupBy('year_of_purchase')
            ->orderBy('year_of_purchase')
            ->get();
    }
}
