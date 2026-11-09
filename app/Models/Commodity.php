<?php

namespace App\Models;

use App\Enums\CommodityCondition;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represent an inventory commodity and define its relations and attribute casts.
 */
#[Fillable([
    'commodity_funding_source_id',
    'commodity_location_id',
    'created_by',
    'updated_by',
    'brand_id',
    'material_id',
    'item_code',
    'qr_code',
    'name',
    'purchase_year',
    'condition',
    'quantity',
    'image',
    'total_price',
    'unit_price',
    'notes',
])]
class Commodity extends Model
{
    use HasFactory;

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
     * Get the user who created the commodity.
     *
     * Relates via the `created_by` column.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the commodity.
     *
     * Relates via the `updated_by` column.
     *
     * @return BelongsTo
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the funding source associated with the commodity.
     *
     * @return BelongsTo
     */
    public function commodityFundingSource(): BelongsTo
    {
        return $this->belongsTo(CommodityFundingSource::class);
    }

    /**
     * Get the location associated with the commodity.
     *
     * @return BelongsTo
     */
    public function commodityLocation(): BelongsTo
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    /**
     * Get the brand associated with the commodity.
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the material associated with the commodity.
     *
     * @return BelongsTo
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
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
        $query->whereAny(['item_code', 'name'], 'like', "%$searchQuery%");
    }
}
