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
     */
    public function mount(Commodity $commodity): void
    {
        $this->commodity = $commodity;
        $this->form->fillFromModel($commodity);
    }

    /**
     * Preview URL for the image.
     * Priority: new upload (temporary) -> persisted image -> null.
     */
    #[Computed]
    public function imagePreview(): ?string
    {
        if ($this->form->image) {
            return $this->form->image->temporaryUrl();
        }

        $path = $this->commodity->image;

        if (! is_string($path) || trim($path) === '') {
            return null;
        }

        return Storage::disk('public')->exists($path)
            ? Storage::url($path)
            : 'https://placehold.co/96x72?text=No+Picture';
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
     * Get a listing of the unique commodity purchase years.
     *
     * @return array<int, mixed>
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
     * @return array<string, string>
     */
    #[Computed]
    public function conditions(): array
    {
        return CommodityCondition::options();
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
     * Reset form fields back to the current commodity values.
     */
    public function resetForm(): void
    {
        $this->form->fillFromModel($this->commodity);
        $this->resetValidation();
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data barang berhasil diubah!');

        $this->redirect(route('barang.index'), navigate: true);
    }

    /**
     * Render the component with a dynamic page title.
     */
    public function render(): View
    {
        return $this->view()->title("Ubah Data Barang: {$this->commodity->name}");
    }
};
