<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\CommodityLocation;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

/**
 * Validate location fields and update the existing commodity location.
 */
class UpdateCommodityLocationForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The commodity location instance.
     */
    public CommodityLocation $commodityLocation;

    /**
     * The location name provided by the user.
     */
    public string $name = '';

    /**
     * Additional details about the location.
     */
    public ?string $description = null;

    /**
     * Validate the input and persist the changes.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorizeModuleAction('ubah', 'ruangan');
        $this->commodityLocation->update($this->validate());
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
