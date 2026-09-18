<?php

use App\CommodityCondition;
use App\Models\CommodityLocation;
use App\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Halaman Daftar Ruangan')] class extends Component
{
    use WithModal, WithPagination;

    /**
     * The number of items to display per page.
     */
    #[Url(as: 'per_page')]
    public int $perPage = 5;

    /**
     * Get a listing of the resource with pagination.
     */
    #[Computed]
    public function commodityLocations(): LengthAwarePaginator
    {
        $query = CommodityLocation::query()->withCount([
            'commodities',
            'commodities as good_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::GOOD),
            'commodities as poor_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::POOR),
            'commodities as heavily_damaged_conditions_count' => fn (Builder $q) => $q->where('condition', CommodityCondition::HEAVILY_DAMAGED),
        ]);

        return $query->paginate($this->perPage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommodityLocation $commodityLocation): void
    {
        $commodityLocation->delete();

        $this->redirect('/ruangan', navigate: true);
    }
};
