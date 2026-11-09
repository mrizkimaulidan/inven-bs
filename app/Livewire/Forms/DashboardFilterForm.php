<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\CommodityCondition;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Livewire\Form;

class DashboardFilterForm extends Form
{
    public string $search = '';

    public string $brandId = '';

    public string $materialId = '';

    public string $locationId = '';

    public string $condition = '';

    public string $purchaseYear = '';

    /**
     * @return array{search: string, brandId: string, materialId: string, locationId: string, condition: string, purchaseYear: string}
     */
    public function values(): array
    {
        return [
            'search' => $this->search,
            'brandId' => $this->brandId,
            'materialId' => $this->materialId,
            'locationId' => $this->locationId,
            'condition' => $this->condition,
            'purchaseYear' => $this->purchaseYear,
        ];
    }

    /**
     * @return array<string, array<int, string|In>>
     */
    protected function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'brandId' => ['nullable', 'integer', 'exists:brands,id'],
            'materialId' => ['nullable', 'integer', 'exists:materials,id'],
            'locationId' => ['nullable', 'integer', 'exists:commodity_locations,id'],
            'condition' => ['nullable', Rule::in(array_keys(CommodityCondition::options()))],
            'purchaseYear' => ['nullable', 'integer', 'digits:4', 'exists:commodities,purchase_year'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'search.max' => 'Pencarian tidak boleh lebih dari 100 karakter.',
            'brandId.integer' => 'Merek yang dipilih tidak valid.',
            'brandId.exists' => 'Merek yang dipilih tidak ditemukan.',
            'materialId.integer' => 'Bahan yang dipilih tidak valid.',
            'materialId.exists' => 'Bahan yang dipilih tidak ditemukan.',
            'locationId.integer' => 'Ruangan yang dipilih tidak valid.',
            'locationId.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'condition.in' => 'Kondisi yang dipilih tidak valid.',
            'purchaseYear.integer' => 'Tahun pembelian yang dipilih tidak valid.',
            'purchaseYear.digits' => 'Tahun pembelian harus terdiri dari empat angka.',
            'purchaseYear.exists' => 'Tahun pembelian yang dipilih tidak ditemukan.',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'search' => 'pencarian',
            'brandId' => 'merek',
            'materialId' => 'bahan',
            'locationId' => 'ruangan',
            'condition' => 'kondisi',
            'purchaseYear' => 'tahun pembelian',
        ];
    }
}
