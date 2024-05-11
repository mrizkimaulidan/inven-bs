<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'condition' => 'integer'
    ];

    /**
     * Get the commodity location associated with the commodity.
     */
    public function commodity_location()
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    /**
     * Get the school operational assistance associated with the commodity.
     */
    public function school_operational_assistance()
    {
        return $this->belongsTo(SchoolOperationalAssistance::class);
    }

    /**
     * Format a date value to Indonesian date format (dd-mm-yyyy).
     */
    public function indonesian_format_date($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Format a currency value to Indonesian currency format.
     */
    public function indonesian_currency($value)
    {
        return number_format($value, 2, ',', '.');
    }

    /**
     * Get the name of the condition based on the condition code.
     */
    public function getConditionName()
    {
        return match ($this->condition) {
            1 => 'Baik',
            2 => 'Kurang Baik',
            3 => 'Rusak Berat',
            default => null
        };
    }
}
