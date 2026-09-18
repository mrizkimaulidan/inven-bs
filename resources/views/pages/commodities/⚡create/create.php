<?php

use App\CommodityCondition;
use App\Livewire\Forms\StoreCommodityForm;
use App\Models\Brand;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Number;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Halaman Tambah Data Barang')] class extends Component
{
    use WithFileUploads;

    /**
     * The form instance.
     */
    public StoreCommodityForm $form;

    /**
     * The available commodity condition options.
     */
    public array $conditions;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->conditions = CommodityCondition::options();
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
     * Get a listing of the users.
     */
    #[Computed]
    public function createdBy(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * Get the total price formatted as Indonesian Rupiah.
     */
    #[Computed]
    public function totalPriceFormatted(): string
    {
        return Number::currency($this->totalPrice, in: 'IDR', locale: 'id');
    }

    /**
     * Get the total price spelled out in Indonesian words.
     */
    #[Computed]
    public function totalInWords(): string
    {
        if ($this->totalPrice <= 0) {
            return '';
        }

        return Number::withLocale('id', function () {
            return ucfirst(Number::spell($this->totalPrice));
        });
    }

    /**
     * Get the raw total price.
     */
    #[Computed]
    public function totalPrice(): float
    {
        return (float) (($this->form->quantity ?? 0) * ($this->form->unit_price ?? 0));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/barang', navigate: true);
    }
};
