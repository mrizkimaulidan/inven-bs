<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represent funding sources and define their commodity relationship.
 */
#[Fillable([
    'name',
    'description',
])]
class CommodityFundingSource extends Model
{
    /**
     * Get the commodities associated with the brand.
     *
     * @return HasMany
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }

    /**
     * Apply the search filter to the query.
     *
     * @param  Builder  $query
     * @param  string  $searchQuery
     * @return void
     */
    #[Scope]
    public function search(Builder $query, string $searchQuery): void
    {
        $query->whereAny(['name', 'description'], 'like', "%$searchQuery%");
    }
}
