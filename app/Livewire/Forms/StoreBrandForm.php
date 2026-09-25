<?php

namespace App\Livewire\Forms;

use App\Models\Brand;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

class StoreBrandForm extends Form
{
    /**
     * The name attribute.
     */
    public string $name = '';

    /**
     * Validate the input and persist a new record.
     */
    public function store(): void
    {
        Brand::create($this->validate());
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
            'name.required' => 'Nama merek wajib diisi!',
            'name.min' => 'Nama merek minimal :min karakter!',
            'name.max' => 'Nama merek maksimal :max karakter!',
        ];
    }
}
