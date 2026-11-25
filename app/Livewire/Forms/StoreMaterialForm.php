<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\Material;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

/**
 * Validate material fields and persist a new material record.
 */
class StoreMaterialForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The material name provided by the user.
     */
    public string $name = '';

    /**
     * Validate the input and persist a new material record.
     */
    public function store(): void
    {
        $this->authorizeModuleAction('tambah', 'bahan');

        $this->name = trim($this->name);

        Material::query()->create($this->validate());
    }

    /**
     * Get the validation rules for the material form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    /**
     * Get the custom validation messages in Indonesian.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Nama bahan wajib diisi!',
            'name.min' => 'Nama bahan minimal :min karakter!',
            'name.max' => 'Nama bahan maksimal :max karakter!',
        ];
    }
}
