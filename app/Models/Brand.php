<?php

namespace App\Models;

use App\HasLogActivity;
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
    use HasFactory, HasLogActivity;

    /**
     * Get the commodities associated with the brand.
     *
     * @return HasMany<Commodity, $this>
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }
}
