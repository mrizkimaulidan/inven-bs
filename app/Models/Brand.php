<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represent commodity brands and define their commodity relationship.
 */
#[Fillable([
    'name',
])]
class Brand extends Model
{
    use HasFactory;

    /**
     * Get the commodities associated with the brand.
     *
     * @return HasMany
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }
}
