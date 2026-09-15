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
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Title('Halaman Tambah Data Barang')] class extends Component
{
    use WithFileUploads;

    public StoreCommodityForm $form;

    public array $conditions;

    public ?TemporaryUploadedFile $image = null;

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
     * Returns an empty string when the total is zero or negative.
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
     * Get the raw total price (quantity multiplied by unit price).
     */
    #[Computed]
    public function totalPrice(): float
    {
        return (float) (($this->form->quantity ?? 0) * ($this->form->unit_price ?? 0));
    }

    /**
     * Store the commodity and redirect to the listing page.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/barang', navigate: true);
    }
};
