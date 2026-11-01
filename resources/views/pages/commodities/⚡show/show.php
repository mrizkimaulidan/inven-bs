<?php

use App\Enums\CommodityCondition;
use App\Models\Commodity;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Load the selected commodity and its related records for the detail view.
 */
new class extends Component
{
    /**
     * The commodity instance.
     */
    public ?Commodity $commodity = null;

    /**
     * Load the selected commodity and its related records.
     *
     * @param  int  $commodityId
     * @return void
     */
    public function mount(int $commodityId): void
    {
        $this->commodity = Commodity::findOrFail($commodityId);

        $this->commodity->load(
            'creator',
            'updater',
            'commodityFundingSource',
            'commodityLocation',
            'brand',
            'material',
        );
    }

    /**
     * Resolve the icon, badge, and label styling for the commodity condition.
     *
     * @return array
     */
    #[Computed]
    public function conditionStyle(): array
    {
        return match ($this->commodity->condition) {
            CommodityCondition::GOOD => [
                'icon' => 'fa-check-circle',
                'badge' => 'badge-success',
                'label' => 'Baik',
            ],
            CommodityCondition::POOR => [
                'icon' => 'fa-exclamation-circle',
                'badge' => 'badge-warning',
                'label' => 'Rusak Ringan',
            ],
            CommodityCondition::HEAVILY_DAMAGED => [
                'icon' => 'fa-times-circle',
                'badge' => 'badge-danger',
                'label' => 'Rusak Berat',
            ],
            default => [
                'icon' => 'fa-question-circle',
                'badge' => 'badge-secondary',
                'label' => 'Tidak Diketahui',
            ],
        };
    }
};
