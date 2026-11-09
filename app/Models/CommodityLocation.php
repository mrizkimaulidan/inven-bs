<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represent storage locations and define their commodity relationship and search scope.
 */
#[Fillable([
    'name',
    'description',
])]
class CommodityLocation extends Model
{
    use HasFactory;

    /**
     * Get the commodities associated with the location.
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
