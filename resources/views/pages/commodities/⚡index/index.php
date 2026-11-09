<?php

use App\Enums\CommodityCondition;
use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithFilters;
use App\Livewire\Concerns\WithModal;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Filter and paginate inventory, manage modal state, and handle commodity actions.
 */
new #[Title('Halaman Daftar Barang')] class extends Component
{
    use WithBulkDelete, WithFilters, WithModal, WithPagination;

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
     * Initialize the default inventory filters.
     *
     * @return void
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
     *
     * @return Collection
     */
    #[Computed]
    public function commodityFundingSources(): Collection
    {
        return CommodityFundingSource::orderBy('name')->get();
    }

    /**
     * Get a listing of the materials.
     *
     * @return Collection
     */
    #[Computed]
    public function materials(): Collection
    {
        return Material::orderBy('name')->get();
    }

    /**
     * Get a listing of the brands.
     *
     * @return Collection
     */
    #[Computed]
    public function brands(): Collection
    {
        return Brand::orderBy('name')->get();
    }

    /**
     * Get a listing of the commodity locations.
     *
     * @return Collection
     */
    #[Computed]
    public function commodityLocations(): Collection
    {
        return CommodityLocation::orderBy('name')->get();
    }

    /**
     * Get a listing of the unique commodity purchase years.
     *
     * @return array
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
     *
     * @return Collection
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * Get a listing of the commodity condition options.
     *
     * @return array
     */
    #[Computed]
    public function conditions(): array
    {
        return CommodityCondition::options();
    }

    /**
     * Map each filter key to its corresponding column, scope, or resolver.
     *
     * @return array
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
            'price_min' => fn (Builder $query, mixed $filterValue) => $query->where('unit_price', '>=', (int) $filterValue),
            'price_max' => fn (Builder $query, mixed $filterValue) => $query->where('unit_price', '<=', (int) $filterValue),
            'quantity_min' => fn (Builder $query, mixed $filterValue) => $query->where('quantity', '>=', (int) $filterValue),
            'quantity_max' => fn (Builder $query, mixed $filterValue) => $query->where('quantity', '<=', (int) $filterValue),
        ];
    }

    /**
     * Get a listing of the commodities with pagination.
     *
     * @return LengthAwarePaginator
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
    /**
     * Resolve the icon and badge styling for a condition.
     *
     * @param  CommodityCondition  $condition
     * @return array
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

    /**
     * Generate a new QR code for the commodity.
     *
     * @param  Commodity  $commodity
     * @return void
     */
    public function generateQrCode(Commodity $commodity): void
    {
        $this->authorizeModuleAction('ubah', 'barang');

        $commodity->update([
            'qr_code' => (string) Str::ulid(),
        ]);

        session()->flash('success', 'Kode QR barang berhasil dibuat.');
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     *
     * @return string
     */
    protected function bulkPaginatorName(): string
    {
        return 'commodities';
    }

    /**
     * Get the destination after a successful bulk delete.
     *
     * @return ?string
     */
    protected function bulkRedirectPath(): ?string
    {
        return '/barang';
    }

    protected function bulkPermissionModule(): string
    {
        return 'barang';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Commodity  $commodity
     * @return void
     */
    public function destroy(Commodity $commodity): void
    {
        $this->authorizeModuleAction('hapus', 'barang');

        $commodity->delete();

        session()->flash('success', 'Data barang berhasil dihapus!');
    }

    /**
     * Called after updating a property.
     *
     * @param  string  $property
     * @return void
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'])) {
            $this->resetPage();
        }

        if ($property === 'search') {
            $this->resetSelection();
        }
    }
};
