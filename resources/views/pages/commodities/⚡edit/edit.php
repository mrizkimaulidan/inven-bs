<?php

use App\Enums\CommodityCondition;
use App\Livewire\Forms\UpdateCommodityForm;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Load commodity options, preview images, and save commodity changes.
 */
new class extends Component
{
    use WithFileUploads;

    /**
     * The data being updated.
     */
    public Commodity $commodity;

    /**
     * The form instance.
     */
    public UpdateCommodityForm $form;

    /**
     * Load the commodity and populate the edit form with its current values.
     *
     * @param  Commodity  $commodity
     * @return void
     */
    public function mount(Commodity $commodity): void
    {
        $this->commodity = $commodity;
        $this->form->fillFromModel($commodity);
    }

    /**
     * Preview URL for the image.
     * Priority: new upload (temporary) → persisted image → null.
     *
     * @return ?string
     */
    #[Computed]
    public function imagePreview(): ?string
    {
        /**
         * Use the temporary URL when the user has selected a replacement image.
         */ if ($this->form->image) {
            return $this->form->image->temporaryUrl();
        }

        /**
         * Otherwise, use the persisted image when available.
         */ $path = $this->commodity->image;

        return $path
            ? (Storage::disk('public')->exists($path) ? Storage::url($path) : asset($path))
            : null;
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
     * Get the total price formatted as Indonesian Rupiah.
     *
     * @return string
     */
    #[Computed]
    public function totalPriceFormatted(): string
    {
        return Number::currency($this->totalPrice, in: 'IDR', locale: 'id');
    }

    /**
     * Get the total price spelled out in Indonesian words.
     *
     * @return string
     */
    #[Computed]
    public function totalInWords(): string
    {
        if ($this->totalPrice <= 0) {
            return '';
        }

        return Number::withLocale('id', fn () => ucfirst(Number::spell($this->totalPrice)));
    }

    /**
     * Get the raw total price.
     *
     * @return float
     */
    #[Computed]
    public function totalPrice(): float
    {
        return (float) (($this->form->quantity ?? 0) * ($this->form->unit_price ?? 0));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data barang berhasil diubah!');

        $this->redirect('/barang', navigate: true);
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return $this->view()->title("Ubah Data Barang: {$this->commodity->name}");
    }
};
