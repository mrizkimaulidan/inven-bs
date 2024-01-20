<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommodityRequest extends FormRequest
{
    protected $errorBag = 'update';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_operational_assistance_id' => 'required|numeric|exists:school_operational_assistances,id',
            'commodity_location_id' => 'required|numeric|exists:commodity_locations,id',
            'item_code' => 'required|unique:commodities,item_code,' . $this->commodity->id . '|min:3|max:255',
            'name' => 'required|string|min:3|max:255',
            'brand' => 'required|string|min:3|max:255',
            'material' => 'required|string|min:3|max:255',
            'year_of_purchase' => 'required|numeric|digits:4',
            'condition' => 'required|in:1,2,3',
            'quantity' => 'required|numeric|digits_between:1,10',
            'price' => 'required|numeric|digits_between:1,10',
            'price_per_item' => 'required|numeric|digits_between:1,10',
            'note' => 'nullable|string|min:3|max:1000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'school_operational_assistance_id.required' => 'Kolom asal perolehan wajib diisi!',
            'school_operational_assistance_id.numeric' => 'Kolom asal perolehan yang dipilih tidak valid!',
            'school_operational_assistance_id.exists' => 'Kolom asal perolehan yang dipilih tidak valid!',

            'commodity_location_id.required' => 'Kolom lokasi barang wajib diisi!',
            'commodity_location_id.numeric' => 'Kolom lokasi barang yang dipilih tidak valid!',
            'commodity_location_id.exists' => 'Kolom lokasi barang yang dipilih tidak valid!',

            'item_code.required' => 'Kolom kode barang wajib diisi!',
            'item_code.unique' => 'Kode barang sudah digunakan. Pilih kode barang lain.',
            'item_code.min' => 'Kolom kode barang minimal :min karakter!',
            'item_code.max' => 'Kolom kode barang maksimal :max karakter!',

            'name.required' => 'Kolom nama barang wajib diisi!',
            'name.string' => 'Kolom nama barang harus berupa karakter!',
            'name.min' => 'Kolom nama barang minimal :min karakter!',
            'name.max' => 'Kolom nama barang maksimal :max karakter!',

            'brand.required' => 'Kolom merek wajib diisi!',
            'brand.string' => 'Kolom merek harus berupa karakter!',
            'brand.min' => 'Kolom merek minimal :min karakter!',
            'brand.max' => 'Kolom merek maksimal :max karakter!',

            'material.required' => 'Kolom bahan wajib diisi!',
            'material.string' => 'Kolom bahan harus berupa karakter!',
            'material.min' => 'Kolom bahan minimal :min karakter!',
            'material.max' => 'Kolom bahan maksimal :max karakter!',

            'year_of_purchase.required' => 'Kolom tahun pembelian wajib diisi!',
            'year_of_purchase.numeric' => 'Kolom tahun pembelian harus berupa angka!',
            'year_of_purchase.digits' => 'Kolom tahun pembelian harus memiliki :digits digit!',

            'condition.required' => 'Kolom kondisi wajib diisi!',
            'condition.in' => 'Kolom kondisi yang dipilih tidak valid!',

            'quantity.required' => 'Kolom kuantitas wajib diisi!',
            'quantity.numeric' => 'Kolom kuantitas harus berupa angka!',
            'quantity.digits_between' => 'Kolom kuantitas harus memiliki antara :min dan :max digit!',

            'price.required' => 'Kolom harga wajib diisi!',
            'price.numeric' => 'Kolom harga harus berupa angka!',
            'price.digits_between' => 'Kolom harga harus memiliki antara :min dan :max digit!',

            'price_per_item.required' => 'Kolom harga satuan wajib diisi!',
            'price_per_item.numeric' => 'Kolom harga satuan harus berupa angka!',
            'price_per_item.digits_between' => 'Kolom harga satuan harus memiliki antara :min dan :max digit!',

            'note.string' => 'Kolom catatan harus berupa teks!',
            'note.min' => 'Kolom catatan minimal :min karakter!',
            'note.max' => 'Kolom catatan maksimal :max karakter!',
        ];
    }
}
