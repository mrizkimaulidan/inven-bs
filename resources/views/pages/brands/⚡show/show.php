<?php

use App\Enums\CommodityCondition;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

/**
 * Load the selected brand and its commodity counts for the detail view.
 */
new class extends Component
{
    /**
     * The brand being displayed.
     */
    public ?Brand $brand = null;

    /**
     * Load the selected brand and its related commodity statistics.
     *
     * @param  int  $brandId
     * @return void
     */
    public function mount(int $brandId): void
    {
        $this->brand = Brand::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($brandId);
    }
};
