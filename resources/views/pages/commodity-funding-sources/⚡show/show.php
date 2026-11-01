<?php

use App\Enums\CommodityCondition;
use App\Models\CommodityFundingSource;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

/**
 * Load the selected funding source and its commodity counts for the detail view.
 */
new class extends Component
{
    /**
     * The funding source being displayed.
     */
    public ?CommodityFundingSource $commodityFundingSource = null;

    /**
     * Load the selected funding source and its related commodity statistics.
     *
     * @param  int  $commodityFundingSourceId
     * @return void
     */
    public function mount(int $commodityFundingSourceId): void
    {
        $this->commodityFundingSource = CommodityFundingSource::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($commodityFundingSourceId);
    }
};
