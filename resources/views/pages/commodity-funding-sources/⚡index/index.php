<?php

use App\CommodityCondition;
use App\Models\CommodityFundingSource;
use App\WithBulkDelete;
use App\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Halaman Daftar Perolehan')] class extends Component
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
     */
    #[Computed]
    public function commodityFundingSources(): LengthAwarePaginator
    {
        $query = CommodityFundingSource::query()->withCount([
            'commodities',
            'commodities as good_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::GOOD),
            'commodities as poor_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::POOR),
            'commodities as heavily_damaged_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::HEAVILY_DAMAGED),
        ]);

        $query->when(filled($this->search), function (Builder $query) {
            $query->search($this->search);
        });

        return $query->paginate($this->perPage);
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     */
    protected function bulkPaginatorName(): string
    {
        return 'commodityFundingSources';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommodityFundingSource $commodityFundingSource): void
    {
        $commodityFundingSource->delete();

        $this->redirect('/ruangan', navigate: true);
    }

    /**
     * Called after updating a property.
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
