<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommodityLocation extends Model
{
    /**
     * Get the commodities associated with this model.
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }
}
