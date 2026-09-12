<?php

use App\CommodityCondition;
use App\Models\Brand;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Halaman Tambah Data Barang')] class extends Component
{
    public array $conditions;

    public function mount(): void
    {
        $this->conditions = CommodityCondition::options();
    }

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
     * Get all users, used for the "created by" filter.
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }
};
