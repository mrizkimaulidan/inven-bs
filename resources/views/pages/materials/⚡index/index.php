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
     * @return LengthAwarePaginator
     */
    #[Computed]
    public function materials(): LengthAwarePaginator
    {
        $query = Material::query()->withCount([
            'commodities',
            'commodities as good_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::GOOD),
            'commodities as poor_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::POOR),
            'commodities as heavily_damaged_conditions_count' => fn (Builder $query) => $query->where('condition', CommodityCondition::HEAVILY_DAMAGED),
        ]);

        $query->when(filled($this->search), function (Builder $query) {
            $query->search($this->search);
        });

        return $query->paginate($this->perPage);
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     *
     * @return string
     */
    protected function bulkPaginatorName(): string
    {
        return 'materials';
    }

    /**
     * Get the destination after a successful bulk delete.
     *
     * @return ?string
     */
    protected function bulkRedirectPath(): ?string
    {
        return '/bahan';
    }

    protected function bulkPermissionModule(): string
    {
        return 'bahan';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Material  $material
     * @return void
     */
    public function destroy(Material $material): void
    {
        $this->authorizeModuleAction('hapus', 'bahan');

        $material->delete();

        session()->flash('success', 'Data bahan berhasil dihapus.');

        $this->redirect('/bahan', navigate: true);
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
