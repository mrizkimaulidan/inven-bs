<?php

namespace App\Repositories;

use App\CommodityAcquisition;

class CommodityAcquisitionRepository
{
    public function __construct(
        private CommodityAcquisition $model
    ) {}

    /**
     * Count commodities by commodity acquisition.
     */
    public function countCommodityByCommodityAcquisition()
    {
        return $this->model->withCount('commodities')->get();
    }
}
