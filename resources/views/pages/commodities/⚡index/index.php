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

    /**
     * The number of items to display per page.
     */
    #[Url(as: 'per_page')]
    public int $perPage = 5;

    /**
     * The search query string.
     */
    #[Url]
    public string $search = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->initializeFilters([
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
        ]);
    }

    /**
     * Get a listing of the commodity funding sources.
     */
    #[Computed]
    public function commodityFundingSources(): Collection
    {
        return CommodityFundingSource::orderBy('name')->get();
    }

    /**
     * Get a listing of the materials.
     */
    #[Computed]
    public function materials(): Collection
    {
        return Material::orderBy('name')->get();
    }

    /**
     * Get a listing of the brands.
     */
    #[Computed]
    public function brands(): Collection
    {
        return Brand::orderBy('name')->get();
    }

    /**
     * Get a listing of the commodity locations.
     */
    #[Computed]
    public function commodityLocations(): Collection
    {
        return CommodityLocation::orderBy('name')->get();
    }

    /**
     * Get a listing of the unique commodity purchase years.
     */
    #[Computed]
    public function purchaseYears(): array
    {
        return Commodity::query()
            ->distinct()
            ->orderByDesc('purchase_year')
            ->pluck('purchase_year')
            ->all();
    }

    /**
     * Get a listing of the users.
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * Get a listing of the commodity condition options.
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
     * Get a listing of the commodities with pagination.
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
     * Get the condition-based summary counts.
     *
     * @return array{total: int, good: int, poor: int, heavily_damaged: int}
     */
    #[Computed]
    public function conditionCounts(): array
    {
        return [
            'total' => (int) Commodity::count(),
            'good' => (int) Commodity::where('condition', CommodityCondition::GOOD)->count(),
            'poor' => (int) Commodity::where('condition', CommodityCondition::POOR)->count(),
            'heavily_damaged' => (int) Commodity::where('condition', CommodityCondition::HEAVILY_DAMAGED)->count(),
        ];
    }

    /**
     * Resolve the icon and badge styling for the given condition.
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
