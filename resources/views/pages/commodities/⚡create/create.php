<?php

use App\Enums\CommodityCondition;
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

/**
 * Load commodity options, calculate totals, and save the commodity and image.
 */
new #[Title('Halaman Tambah Data Barang')] class extends Component
{
    use WithFileUploads;

    /**
     * The form instance.
     */
    public StoreCommodityForm $form;

    /**
     * The available commodity condition options.
     *
     * @var array<string, string>
     */
    public array $conditions = [];

    /**
     * Load the available condition options for the form.
     */
    public function mount(): void
    {
        $this->conditions = CommodityCondition::options();
    }

    /**
     * Get a listing of the commodity funding sources.
     *
     * @return Collection<int, CommodityFundingSource>
     */
    #[Computed]
    public function commodityFundingSources(): Collection
    {
        return CommodityFundingSource::orderBy('name')->get();
    }

    /**
     * Get a listing of the materials.
     *
     * @return Collection<int, Material>
     */
    #[Computed]
    public function materials(): Collection
    {
        return Material::orderBy('name')->get();
    }

    /**
     * Get a listing of the brands.
     *
     * @return Collection<int, Brand>
     */
    #[Computed]
    public function brands(): Collection
    {
        return Brand::orderBy('name')->get();
    }

    /**
     * Get a listing of the commodity locations.
     *
     * @return Collection<int, CommodityLocation>
     */
    #[Computed]
    public function commodityLocations(): Collection
    {
        return CommodityLocation::orderBy('name')->get();
    }

    /**
     * Get a listing of the users.
     *
     * @return Collection<int, User>
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

        return Number::withLocale('id', function (): string {
            return ucfirst(Number::spell($this->totalPrice));
        });
    }

    /**
     * Get the raw total price.
     */
    #[Computed]
    public function totalPrice(): float
    {
        $quantity = is_numeric($this->form->quantity ?? null) ? (float) $this->form->quantity : 0.0;
        $unitPrice = is_numeric($this->form->unit_price ?? null) ? (float) $this->form->unit_price : 0.0;

        return max(0.0, $quantity) * max(0.0, $unitPrice);
    }

    /**
     * Preview URL for the uploaded image.
     */
    #[Computed]
    public function imagePreview(): ?string
    {
        return $this->form->image ? $this->form->image->temporaryUrl() : null;
    }

    /**
     * Reset form fields and clear validation errors.
     */
    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        session()->flash('success', 'Data barang berhasil ditambahkan!');

        $this->redirect(route('barang.index'), navigate: true);
    }
};
