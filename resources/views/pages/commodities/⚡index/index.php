<?php

use App\CommodityCondition;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use App\WithFilters;
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
    use WithFilters, WithModal, WithPagination;

    #[Url(as: 'per_page')]
    public int $perPage = 5;

    #[Url]
    public string $search = '';

    #[Url]
    public array $filters = [
        'category' => '',
        'condition' => '',
        'purchase_year' => '',
        'funding_source' => '',
        'material' => '',
        'brand' => '',
        'location' => '',
        'created_by' => '',
        'price_min' => '',
        'price_max' => '',
        'quantity_min' => '',
        'quantity_max' => '',
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
     * Get all unique commodity purchase years.
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
     * Get all users, used for the "created by" filter.
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * Get all available commodity condition options.
     */
    #[Computed]
    public function conditions(): array
    {
        return CommodityCondition::options();
    }

    /**
     * Map each filter key to its corresponding column, scope, or resolver.
     */
    protected function filterMap(): array
    {
        return [
            'condition' => ['scope' => 'whereCondition', 'cast' => 'int'],
            'purchase_year' => ['scope' => 'wherePurchaseYear', 'cast' => 'int'],
            'funding_source' => ['column' => 'commodity_funding_source_id', 'cast' => 'int'],
            'material' => ['column' => 'material_id', 'cast' => 'int'],
            'brand' => ['column' => 'brand_id', 'cast' => 'int'],
            'location' => ['column' => 'commodity_location_id', 'cast' => 'int'],
            'created_by' => ['column' => 'created_by', 'cast' => 'int'],
            'price_min' => fn (Builder $query, mixed $value) => $query->where('unit_price', '>=', (int) $value),
            'price_max' => fn (Builder $query, mixed $value) => $query->where('unit_price', '<=', (int) $value),
            'quantity_min' => fn (Builder $query, mixed $value) => $query->where('quantity', '>=', (int) $value),
            'quantity_max' => fn (Builder $query, mixed $value) => $query->where('quantity', '<=', (int) $value),
        ];
    }

    /**
     * Get the paginated, filtered list of commodities.
     */
    #[Computed]
    public function commodities(): LengthAwarePaginator
    {
        $query = Commodity::query()->with(['commodityFundingSource', 'commodityLocation', 'brand', 'material']);

        $query->when(filled($this->search), function (Builder $query) {
            $query->search($this->search);
        });

        $this->applyFilters($query, $this->filterMap());

        return $query->paginate($this->perPage);
    }

    /**
     * Get the total number of commodities.
     */
    #[Computed]
    public function totalCommoditiesCount(): int
    {
        return Commodity::count();
    }

    /**
     * Get the count of commodities in good condition.
     */
    #[Computed]
    public function goodConditionCount(): int
    {
        return Commodity::where('condition', CommodityCondition::GOOD)->count();
    }

    /**
     * Get the count of commodities in poor condition.
     */
    #[Computed]
    public function poorConditionCount(): int
    {
        return Commodity::where('condition', CommodityCondition::POOR)->count();
    }

    /**
     * Get the count of heavily damaged commodities.
     */
    #[Computed]
    public function heavilyDamagedCount(): int
    {
        return Commodity::where('condition', CommodityCondition::HEAVILY_DAMAGED)->count();
    }

    /**
     * Resolve the icon and badge styling for a given commodity condition.
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
            ],
        };
    }
};
