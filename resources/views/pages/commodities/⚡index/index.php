<?php

use App\CommodityCondition;
use App\Models\Commodity;
use App\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Halaman Daftar Barang')] class extends Component
{
    use WithModal, WithPagination;

    #[Url(as: 'per_page')]
    public int $perPage = 5;

    #[Url]
    public string $search = '';

    /**
     * Get the paginated list of commodities.
     */
    #[Computed]
    public function commodities(): LengthAwarePaginator
    {
        $model = Commodity::query()->with(['commodityFundingSource', 'commodityLocation', 'brand', 'material']);
        $model->when(filled($this->search), function (Builder $query) {
            $query->search($this->search);
        });

        return $model->paginate($this->perPage);
    }

    /**
     * Get the total number of commodities.
     *
     * @return int Total count of all commodities
     */
    #[Computed]
    public function totalCommoditiesCount(): int
    {
        return Commodity::count();
    }

    /**
     * Get the count of commodities in good condition.
     *
     * @return int Number of commodities with GOOD condition
     */
    #[Computed]
    public function goodConditionCount(): int
    {
        return Commodity::where('condition', CommodityCondition::GOOD)->count();
    }

    /**
     * Get the count of commodities in poor condition.
     *
     * @return int Number of commodities with POOR condition
     */
    #[Computed]
    public function poorConditionCount(): int
    {
        return Commodity::where('condition', CommodityCondition::POOR)->count();
    }

    /**
     * Get the count of commodities that are heavily damaged.
     *
     * @return int Number of commodities with HEAVILY_DAMAGED condition
     */
    #[Computed]
    public function heavilyDamagedCount(): int
    {
        return Commodity::where('condition', CommodityCondition::HEAVILY_DAMAGED)->count();
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

    /**
     * Handle Livewire property updates.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search'])) {
            $this->resetPage();
        }
    }
};
