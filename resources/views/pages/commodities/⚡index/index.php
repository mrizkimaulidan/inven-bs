<?php

use App\CommodityCondition;
use App\Models\Commodity;
use App\WithModal;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Halaman Daftar Barang')] class extends Component
{
    use WithModal;

    /**
     * Get the paginated list of commodities.
     */
    #[Computed]
    public function commodities(): LengthAwarePaginator
    {
        return Commodity::paginate(5);
    }

    /**
     * Get the CSS and icon configuration for a commodity condition.
     *
     * @return array<string, string>
     */
    public function conditionStyle(CommodityCondition $condition): array
    {
        return match ($condition) {
            CommodityCondition::GOOD => [
                'icon' => 'fa-check-circle',
                'badge' => 'badge-success',
            ],
            CommodityCondition::POOR => [
                'icon' => 'fa-exclamation-circle',
                'badge' => 'badge-warning',
            ],
            CommodityCondition::HEAVILY_DAMAGED => [
                'icon' => 'fa-circle-xmark',
                'badge' => 'badge-danger',
            ]
        };
    }
};
