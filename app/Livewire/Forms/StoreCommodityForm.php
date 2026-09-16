<?php

namespace App\Livewire\Forms;

use App\Models\Commodity;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class StoreCommodityForm extends Form
{
    public ?TemporaryUploadedFile $image = null;

    public int $commodity_location_id;

    public int $commodity_funding_source_id;

    public int $brand_id;

    public int $material_id;

    public string $name;

    public string $item_code;

    public ?string $qr_code = null;

    public int $purchase_year;

    public int $condition;

    public ?int $quantity = 0;

    public ?int $unit_price = 0;

    public ?string $notes = null;

    /**
     * Validate and store the commodity.
     */
    public function store(): void
    {
        $validated = $this->validate();

        $validated['quantity'] = $this->quantity ?? 0;
        $validated['unit_price'] = $this->unit_price ?? 0;
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['created_by'] = 1;
        $validated['updated_by'] = 1;

        $validated['image'] = $this->image->store('barang', 'public');

        Commodity::create($validated);
    }

    /**
     * Get the validation rules for the form.
     */
    protected function rules(): array
    {
        return [
            'commodity_location_id' => ['required', 'exists:commodity_locations,id'],
            'commodity_funding_source_id' => ['required', 'exists:commodity_funding_sources,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'material_id' => ['required', 'exists:materials,id'],
            'name' => ['required', 'string', 'max:255'],
            'item_code' => ['required', 'string', 'max:255', 'unique:commodities,item_code'],
            'qr_code' => ['nullable', 'string', 'max:255', 'unique:commodities,qr_code'],
            'purchase_year' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'condition' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom validation messages.
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

            'image.required' => 'Gambar barang wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',

            'unit_price.numeric' => 'Harga satuan harus berupa angka.',
            'unit_price.min' => 'Harga satuan tidak boleh negatif.',

            'notes.string' => 'Catatan harus berupa teks.',
        ];
    }

    /**
     * Get custom attribute names for validation.
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
