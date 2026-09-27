<?php

use App\CommodityCondition;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

new class extends Component
{
    /**
     * The material instance.
     */
    public ?Material $material = null;

    /**
     * Mount the component.
     */
    public function mount(int $materialId): void
    {
        $this->material = Material::query()
            ->withCount([
                'commodities',
                'commodities as good_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::GOOD),
                'commodities as poor_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::POOR),
                'commodities as heavily_damaged_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::HEAVILY_DAMAGED),
            ])
            ->findOrFail($materialId);
    }
};
