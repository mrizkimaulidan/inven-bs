<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $guarded = [];

    public function commodity_location()
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    public function school_operational_assistance()
    {
        return $this->belongsTo(SchoolOperationalAssistance::class);
    }

    public function indonesian_format_date($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function indonesian_currency($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
