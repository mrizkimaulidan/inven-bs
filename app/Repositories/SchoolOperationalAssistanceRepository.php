<?php

namespace App\Repositories;

use App\SchoolOperationalAssistance;

class SchoolOperationalAssistanceRepository
{
    public  function __construct(
        private SchoolOperationalAssistance $model
    ) {
    }

    /**
     * Count commodities by school operational assistance.
     */
    public function countCommodityBySchoolOperationalAssistance()
    {
        return $this->model->withCount('commodities')->get();
    }
}
