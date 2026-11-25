<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\CommodityLocation;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

/**
 * Validate location fields and update an existing commodity location record.
 */
class UpdateCommodityLocationForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The commodity location model instance being updated.
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
     * Validate the input and persist changes to the location record.
     */
    public function update(): void
    {
        $this->authorizeModuleAction('ubah', 'ruangan');

        $this->name = trim($this->name);
        $this->description = $this->description !== null ? trim($this->description) : null;

        $this->commodityLocation->update($this->validate());
    }

    /**
     * Get the validation rules for the location update form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string'],
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
            'name.required' => 'Nama ruangan wajib diisi!',
            'name.min' => 'Nama ruangan minimal :min karakter!',
            'name.max' => 'Nama ruangan maksimal :max karakter!',

            'description.string' => 'Deskripsi ruangan harus berupa teks!',
        ];
    }
}
