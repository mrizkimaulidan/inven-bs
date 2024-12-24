<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityAcquisition extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the commodities associated with the commodity location.
     */
    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }
}
