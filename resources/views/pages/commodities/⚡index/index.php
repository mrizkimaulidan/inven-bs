<?php

use App\CommodityCondition;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use App\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    #[Url]
    public array $filters = [
        'condition' => '',
        'purchase_year' => '',
        'funding_source' => '',
        'material' => '',
        'brand' => '',
        'location' => '',
        'created_by' => '',
    ];

    /**
     * Get all commodity funding sources.
     */
    #[Computed]
    public function commodityFundingSources(): Collection
    {
        return CommodityFundingSource::orderBy('name')->get();
    }

    /**
     * Get all materials.
     */
    #[Computed]
    public function materials(): Collection
    {
        return Material::orderBy('name')->get();
    }

    /**
     * Get all brands.
     */
    #[Computed]
    public function brands(): Collection
    {
        return Brand::orderBy('name')->get();
    }

    /**
     * Get all commodity locations.
     */
    #[Computed]
    public function commodityLocations(): Collection
    {
        return CommodityLocation::orderBy('name')->get();
    }

    /**
     * Get all unique purchase years.
     */
    #[Computed]
    public function purchaseYears(): array
    {
        return Commodity::query()
            ->distinct()
            ->orderBy('purchase_year')
            ->pluck('purchase_year')
            ->all();
    }

    /**
     * Get all users.
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * Get all commodity conditions.
     */
    #[Computed]
    public function conditions(): array
    {
        return CommodityCondition::options();
    }

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

        $model->when(filled($this->filters['condition']), function (Builder $query) {
            $query->whereCondition((int) $this->filters['condition']);
        });

        $model->when(filled($this->filters['purchase_year']), function (Builder $query) {
            $query->wherePurchaseYear((int) $this->filters['purchase_year']);
        });

        $model->when(filled($this->filters['funding_source']), function (Builder $query) {
            $query->where('commodity_funding_source_id', (int) $this->filters['funding_source']);
        });

        $model->when(filled($this->filters['material']), function (Builder $query) {
            $query->where('material_id', (int) $this->filters['material']);
        });

        $model->when(filled($this->filters['brand']), function (Builder $query) {
            $query->where('brand_id', (int) $this->filters['brand']);
        });

        $model->when(filled($this->filters['location']), function (Builder $query) {
            $query->where('commodity_location_id', (int) $this->filters['location']);
        });

        $model->when(filled($this->filters['created_by']), function (Builder $query) {
            $query->where('created_by', (int) $this->filters['created_by']);
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
     * Reset filters
     */
    public function resetFilters(): void
    {
        $this->reset('filters');
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
