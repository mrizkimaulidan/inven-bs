<?php

namespace App\Livewire\Forms;

use App\Models\CommodityLocation;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

class StoreCommodityLocationForm extends Form
{
    public string $name;

    public ?string $description = null;

    /**
     * Store a newly created resource in storage.
     */
    public function store(): void
    {
        $validated = $this->validate();

        CommodityLocation::create($validated);
    }

    /**
     * Get the validation rules that apply to the request.
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
     * Get the error messages for the defined validation rules.
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
