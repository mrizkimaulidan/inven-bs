<?php

use App\CommodityCondition;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

new class extends Component
{
    /**
     * The commodity location instance.
     */
    public ?Brand $brand = null;

    /**
     * Mount the component.
     */
    public function mount(int $brandId): void
    {
        $this->brand = Brand::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($brandId);
    }
};
