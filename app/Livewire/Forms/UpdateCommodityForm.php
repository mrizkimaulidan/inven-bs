<?php

namespace App\Livewire\Forms;

use App\CommodityCondition;
use App\Models\Commodity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class UpdateCommodityForm extends Form
{
    /**
     * The commodity instance.
     */
    public Commodity $commodity;

    /**
     * The image attribute.
     */
    public ?TemporaryUploadedFile $image = null;

    /**
     * The commodity location attribute.
     */
    public int $commodity_location_id = 0;

    /**
     * The commodity funding source attribute.
     */
    public int $commodity_funding_source_id = 0;

    /**
     * The brand attribute.
     */
    public int $brand_id = 0;

    /**
     * The material attribute.
     */
    public int $material_id = 0;

    /**
     * The name attribute.
     */
    public string $name = '';

    /**
     * The item code attribute.
     */
    public string $item_code = '';

    /**
     * The QR code attribute.
     */
    public ?string $qr_code = null;

    /**
     * The purchase year attribute.
     */
    public int $purchase_year = 0;

    /**
     * The condition attribute.
     */
    public CommodityCondition $condition;

    /**
     * The quantity attribute.
     */
    public ?int $quantity = 0;

    /**
     * The unit price attribute.
     */
    public ?int $unit_price = 0;

    /**
     * The notes attribute.
     */
    public ?string $notes = null;

    /**
     * Validate the input and persist a new record.
     */
    public function update(): void
    {
        $validated = collect($this->validate())->except('image');

        $quantity = $this->quantity ?? 0;
        $unitPrice = $this->unit_price ?? 0;

        $validated->put('quantity', $quantity);
        $validated->put('unit_price', $unitPrice);
        $validated->put('total_price', $quantity * $unitPrice);
        $validated->put('updated_by', auth()->id());

        if ($this->image) {
            $path = $this->image->store('barang', 'public');

            if ($this->commodity->image && Storage::disk('public')->exists($this->commodity->image)) {
                Storage::disk('public')->delete($this->commodity->image);
            }

            $validated->put('image', $path);
        }

        $this->commodity->update($validated->toArray());
    }

    /**
     * Get the validation rules for the form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'commodity_location_id' => ['required', 'exists:commodity_locations,id'],
            'commodity_funding_source_id' => ['required', 'exists:commodity_funding_sources,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'material_id' => ['required', 'exists:materials,id'],
            'name' => ['required', 'string', 'max:255'],
            'item_code' => ['required', 'string', 'max:255', Rule::unique('commodities', 'item_code')->ignore($this->commodity->id)],
            'qr_code' => ['nullable', 'string', 'max:255', Rule::unique('commodities', 'qr_code')->ignore($this->commodity->id)],
            'purchase_year' => ['required', 'integer', 'min:1900', 'max:'.now()->year],
            'condition' => [
                'required',
                Rule::enum(CommodityCondition::class),
            ],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'commodity_location_id.required' => 'Lokasi barang wajib dipilih.',
            'commodity_location_id.exists' => 'Lokasi barang yang dipilih tidak valid.',

            'commodity_funding_source_id.required' => 'Sumber dana wajib dipilih.',
            'commodity_funding_source_id.exists' => 'Sumber dana yang dipilih tidak valid.',

            'brand_id.required' => 'Merek wajib dipilih.',
            'brand_id.exists' => 'Merek yang dipilih tidak valid.',

            'material_id.required' => 'Bahan wajib dipilih.',
            'material_id.exists' => 'Bahan yang dipilih tidak valid.',

            'name.required' => 'Nama barang wajib diisi.',
            'name.string' => 'Nama barang harus berupa teks.',
            'name.max' => 'Nama barang maksimal 255 karakter.',

            'item_code.required' => 'Kode barang wajib diisi.',
            'item_code.string' => 'Kode barang harus berupa teks.',
            'item_code.max' => 'Kode barang maksimal 255 karakter.',
            'item_code.unique' => 'Kode barang sudah digunakan.',

            'qr_code.string' => 'Kode QR harus berupa teks.',
            'qr_code.max' => 'Kode QR maksimal 255 karakter.',
            'qr_code.unique' => 'Kode QR sudah digunakan.',

            'purchase_year.required' => 'Tahun pembelian wajib diisi.',
            'purchase_year.integer' => 'Tahun pembelian harus berupa angka.',
            'purchase_year.min' => 'Tahun pembelian minimal 1900.',
            'purchase_year.max' => 'Tahun pembelian tidak boleh melebihi tahun sekarang.',

            'condition.required' => 'Kondisi barang wajib dipilih.',
            'condition.integer' => 'Kondisi barang tidak valid.',

            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah tidak boleh negatif.',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',

            'unit_price.numeric' => 'Harga satuan harus berupa angka.',
            'unit_price.min' => 'Harga satuan tidak boleh negatif.',

            'notes.string' => 'Catatan harus berupa teks.',
        ];
    }

    /**
     * Get the custom validation attribute names.
     *
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'commodity_location_id' => 'lokasi barang',
            'commodity_funding_source_id' => 'sumber dana',
            'brand_id' => 'merek',
            'material_id' => 'bahan',
            'name' => 'nama barang',
            'item_code' => 'kode barang',
            'qr_code' => 'kode QR',
            'purchase_year' => 'tahun pembelian',
            'condition' => 'kondisi barang',
            'quantity' => 'jumlah',
            'image' => 'gambar',
            'unit_price' => 'harga satuan',
            'notes' => 'catatan',
        ];
    }
}
