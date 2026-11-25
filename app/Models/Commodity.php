<?php

namespace App\Models;

use App\Enums\CommodityCondition;
use App\HasLogActivity;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represent an inventory commodity and define its relations, casts, and search scope.
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
    use HasFactory, HasLogActivity;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, class-string<CommodityCondition>|string>
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
     * @return BelongsTo<User, $this>
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
     * @return BelongsTo<User, $this>
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the funding source associated with the commodity.
     *
     * @return BelongsTo<CommodityFundingSource, $this>
     */
    public function commodityFundingSource(): BelongsTo
    {
        return $this->belongsTo(CommodityFundingSource::class);
    }

    /**
     * Get the location associated with the commodity.
     *
     * @return BelongsTo<CommodityLocation, $this>
     */
    public function commodityLocation(): BelongsTo
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    /**
     * Get the brand associated with the commodity.
     *
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the material associated with the commodity.
     *
     * @return BelongsTo<Material, $this>
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Apply the search filter to the commodity query.
     *
     * @param  Builder<static>  $query
     */
    #[Scope]
    public function search(Builder $query, string $searchQuery): void
    {
        $query->whereAny(['item_code', 'name'], 'like', '%'.$searchQuery.'%');
    }
}
