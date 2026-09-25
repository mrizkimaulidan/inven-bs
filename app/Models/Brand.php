<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
])]
class Brand extends Model
{
    /**
     * Get the commodities associated with the brand.
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }
}
