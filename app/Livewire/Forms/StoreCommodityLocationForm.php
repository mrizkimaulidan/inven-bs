<?php

namespace App\Livewire\Forms;

use App\Models\CommodityLocation;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

class StoreCommodityLocationForm extends Form
{
    /**
     * The location name provided by the user.
     */
    public string $name = '';

    /**
     * Additional details about the location.
     */
    public ?string $description = null;

    /**
     * Validate the input and persist a new record.
     */
    public function store(): void
    {
        CommodityLocation::create($this->validate());
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
