<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\Brand;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

/**
 * Validate brand fields and update an existing brand record.
 */
class UpdateBrandForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The brand model instance being updated.
     */
    public Brand $brand;

    /**
     * The brand name provided by the user.
     */
    public string $name = '';

    /**
     * Validate the input and persist the changes to the brand record.
     */
    public function update(): void
    {
        $this->authorizeModuleAction('ubah', 'merek');

        $this->name = trim($this->name);

        $this->brand->update($this->validate());
    }

    /**
     * Get the validation rules for the brand form.
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
            'name.required' => 'Nama merek wajib diisi!',
            'name.min' => 'Nama merek minimal :min karakter!',
            'name.max' => 'Nama merek maksimal :max karakter!',
        ];
    }
}
