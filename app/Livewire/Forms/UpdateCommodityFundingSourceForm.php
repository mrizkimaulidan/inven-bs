<?php

namespace App\Livewire\Forms;

use App\Models\CommodityFundingSource;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

class UpdateCommodityFundingSourceForm extends Form
{
    /**
     * The commodity funding source instance.
     */
    public CommodityFundingSource $commodityFundingSource;

    /**
     * The name attribute.
     */
    public string $name = '';

    /**
     * The description attribute.
     */
    public ?string $description = null;

    /**
     * Validate the input and persist the changes.
     */
    public function update(): void
    {
        $this->commodityFundingSource->update($this->validate());
    }

    /**
     * Get the validation rules for the form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['nullable', 'string'],
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
            'name.required' => 'Nama ruangan wajib diisi!',
            'name.min' => 'Nama ruangan minimal :min karakter!',
            'name.max' => 'Nama ruangan maksimal :max karakter!',

            'description.string' => 'Deskripsi ruangan harus berupa karakter!',
        ];
    }
}
