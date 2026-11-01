<?php

use App\Enums\CommodityCondition;
use App\Models\CommodityLocation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

/**
 * Load the selected location and its commodity counts for the detail view.
 */
new class extends Component
{
    /**
     * The commodity location instance.
     */
    public ?CommodityLocation $commodityLocation = null;

    /**
     * Load the selected location and its related commodity statistics.
     *
     * @param  int  $commodityLocationId
     * @return void
     */
    public function mount(int $commodityLocationId): void
    {
        $this->commodityLocation = CommodityLocation::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($commodityLocationId);
    }
};
