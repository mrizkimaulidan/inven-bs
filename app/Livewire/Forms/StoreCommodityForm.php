<?php

namespace App\Livewire\Forms;

use App\Models\Commodity;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class StoreCommodityForm extends Form
{
    /**
     * The image uploaded for the commodity.
     */
    public ?TemporaryUploadedFile $image = null;

    /**
     * The selected location ID.
     */
    public int $commodity_location_id = 0;

    /**
     * The selected funding source ID.
     */
    public int $commodity_funding_source_id = 0;

    /**
     * The selected brand ID.
     */
    public int $brand_id = 0;

    /**
     * The selected material ID.
     */
    public int $material_id = 0;

    /**
     * The commodity name provided by the user.
     */
    public string $name = '';

    /**
     * The unique code assigned to the commodity.
     */
    public string $item_code = '';

    /**
     * The QR code value assigned to the commodity.
     */
    public ?string $qr_code = null;

    /**
     * The year the commodity was purchased.
     */
    public int $purchase_year = 0;

    /**
     * The current condition of the commodity.
     */
    public int $condition = 0;

    /**
     * The number of commodity units.
     */
    public ?int $quantity = 0;

    /**
     * The price of one commodity unit.
     */
    public ?int $unit_price = 0;

    /**
     * Additional notes about the commodity.
     */
    public ?string $notes = null;

    /**
     * Validate the input and persist a new record.
     */
    public function store(): void
    {
        $validated = $this->validate();

        $validated['qr_code'] = (string) Str::ulid();

        $validated['quantity'] = $this->quantity ?? 0;
        $validated['unit_price'] = $this->unit_price ?? 0;
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['created_by'] = auth()->id() ?? 1;
        $validated['updated_by'] = auth()->id() ?? 1;

        $validated['image'] = $this->image->store('barang', 'public');

        Commodity::create($validated);
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
            'item_code' => ['required', 'string', 'max:255', 'unique:commodities,item_code'],
            'purchase_year' => ['required', 'integer', 'min:1900', 'max:'.now()->year],
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
