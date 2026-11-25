<?php

use App\Enums\CommodityCondition;
use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithModal;
use App\Models\CommodityLocation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Provide the commodity locations listing, filters, pagination, and record actions.
 */
new #[Title('Halaman Daftar Ruangan')] class extends Component
{
    use WithBulkDelete, WithModal, WithPagination;

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
     * Get a listing of the resource with pagination.
     *
     * @return LengthAwarePaginator<int, CommodityLocation>
     */
    #[Computed]
    public function commodityLocations(): LengthAwarePaginator
    {
        $perPage = max(1, $this->perPage);
        $keyword = trim($this->search);

        $query = CommodityLocation::query()->withCount([
            'commodities',
            'commodities as good_conditions_count' => static fn (Builder $query): Builder => $query->where('condition', CommodityCondition::GOOD),
            'commodities as poor_conditions_count' => static fn (Builder $query): Builder => $query->where('condition', CommodityCondition::POOR),
            'commodities as heavily_damaged_conditions_count' => static fn (Builder $query): Builder => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
        ]);

        $query->when($keyword !== '', static function (Builder $query) use ($keyword): void {
            $query->search($keyword);
        });

        return $query->paginate($perPage);
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     */
    protected function bulkPaginatorName(): string
    {
        return 'commodityLocations';
    }

    /**
     * Get the destination after a successful bulk delete.
     */
    protected function bulkRedirectPath(): ?string
    {
        return route('ruangan.index');
    }

    /**
     * Get the permission module name used by bulk delete actions.
     */
    protected function bulkPermissionModule(): string
    {
        return 'ruangan';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommodityLocation $commodityLocation): void
    {
        $this->authorizeModuleAction('hapus', 'ruangan');

        $commodityLocation->delete();

        session()->flash('success', 'Data ruangan berhasil dihapus.');

        $this->redirect(route('ruangan.index'), navigate: true);
    }

    /**
     * Reset pagination and selection state when filter or page-size properties change.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'], true)) {
            $this->resetPage();
        }

        if ($property === 'search') {
            $this->resetSelection();
        }
    }
};
