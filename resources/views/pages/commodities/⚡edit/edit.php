<?php

use App\CommodityCondition;
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
     * The current image URL.
     */
    public string $currentImage;

    /**
     * Mount the component.
     */
    public function mount(Commodity $commodity): void
    {
        $this->commodity = $commodity;

        if (Storage::disk('public')->exists($commodity->image)) {
            $this->currentImage = Storage::url($commodity->image);
        }

        $this->form->fill([
            'commodity' => $commodity,
            'commodity_funding_source_id' => $commodity->commodity_funding_source_id,
            'commodity_location_id' => $commodity->commodity_location_id,
            'brand_id' => $commodity->brand_id,
            'material_id' => $commodity->material_id,
            'item_code' => $commodity->item_code,
            'qr_code' => $commodity->qr_code,
            'name' => $commodity->name,
            'purchase_year' => $commodity->purchase_year,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'unit_price' => $commodity->unit_price,
            'notes' => $commodity->notes,
        ]);
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
     * Get a listing of the unique commodity purchase years.
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
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/barang', navigate: true);
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return $this->view()->title("Ubah Data Barang: {$this->commodity->name}");
    }
};
