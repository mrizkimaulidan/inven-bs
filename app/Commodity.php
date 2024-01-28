<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $guarded = [];

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
        if ($this->condition === 1) {
            return 'Baik';
        }

        if ($this->condition === 2) {
            return 'Kurang Baik';
        }

        if ($this->condition === 3) {
            return 'Rusak Berat';
        }

        // Return null if the condition code is not recognized
        return null;
    }
}
