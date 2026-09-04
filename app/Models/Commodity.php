<?php

namespace App\Models;

use App\CommodityCondition;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commodity extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'condition' => CommodityCondition::class,
        ];
    }

    /**
     * Get the funding source associated with the commodity.
     */
    public function commodityFundingSource(): BelongsTo
    {
        return $this->belongsTo(CommodityFundingSource::class);
    }

    /**
     * Get the location associated with the commodity.
     */
    public function commodityLocation(): BelongsTo
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    /**
     * Get the brand associated with the commodity.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the material associated with the commodity.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Apply search filter to the query.
     */
    #[Scope]
    public function search(Builder $query, string $searchQuery): void
    {
        $query->whereAny(['item_code', 'name'], 'like', "%$searchQuery%");
    }
}
