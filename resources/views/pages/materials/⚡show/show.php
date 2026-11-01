<?php

use App\Enums\CommodityCondition;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

/**
 * Load the selected material and its commodity counts for the detail view.
 */
new class extends Component
{
    /**
     * The material instance.
     */
    public ?Material $material = null;

    /**
     * Load the selected material and its related commodity statistics.
     *
     * @param  int  $materialId
     * @return void
     */
    public function mount(int $materialId): void
    {
        $this->material = Material::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($materialId);
    }
};
