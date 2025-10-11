<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommodityLocation extends Model
{
    protected $guarded = [];

    /**
     * Get the commodities associated with the commodity location.
     */
    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
