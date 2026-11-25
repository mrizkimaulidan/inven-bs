<?php

namespace App\Models;

use App\HasLogActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represent commodity materials and define their commodity relationship and search scope.
 */
#[Fillable([
    'name',
])]
class Material extends Model
{
    use HasFactory, HasLogActivity;

    /**
     * Get the commodities associated with the material.
     *
     * @return HasMany<Commodity, $this>
     */
    public function commodities(): HasMany
    {
        return $this->hasMany(Commodity::class);
    }

    /**
     * Apply the search filter to the material query.
     *
     * @param  Builder<static>  $query
     */
    #[Scope]
    public function search(Builder $query, string $searchQuery): void
    {
        $query->whereAny(['name'], 'like', '%'.$searchQuery.'%');
    }
}
