<?php

use App\Enums\CommodityCondition;
use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithModal;
use App\Models\Material;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Provide the materials listing, filters, pagination, and record actions.
 */
new #[Title('Halaman Daftar Bahan')] class extends Component
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
     * @return LengthAwarePaginator<int, Material>
     */
    #[Computed]
    public function materials(): LengthAwarePaginator
    {
        $perPage = max(1, $this->perPage);
        $keyword = trim($this->search);

        $query = Material::query()->withCount([
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
        return 'materials';
    }

    /**
     * Get the destination after a successful bulk delete.
     */
    protected function bulkRedirectPath(): ?string
    {
        return route('bahan.index');
    }

    /**
     * Get the permission module name used by bulk delete actions.
     */
    protected function bulkPermissionModule(): string
    {
        return 'bahan';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material): void
    {
        $this->authorizeModuleAction('hapus', 'bahan');

        $material->delete();

        session()->flash('success', 'Data bahan berhasil dihapus.');

        $this->redirect(route('bahan.index'), navigate: true);
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
