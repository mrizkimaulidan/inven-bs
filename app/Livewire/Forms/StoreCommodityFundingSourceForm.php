<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\CommodityFundingSource;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;

/**
 * Validate funding source fields and create a new funding source record.
 */
class StoreCommodityFundingSourceForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The funding source name provided by the user.
     */
    public string $name = '';

    /**
     * Additional details about the funding source.
     */
    public ?string $description = null;

    /**
     * Validate the input and persist a new funding source record.
     */
    public function store(): void
    {
        $this->authorizeModuleAction('tambah', 'perolehan');

        $this->name = trim($this->name);
        $this->description = $this->description !== null ? trim($this->description) : null;

        CommodityFundingSource::query()->create($this->validate());
    }

    /**
     * Get the validation rules for the funding source form.
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
            'name.required' => 'Nama perolehan wajib diisi!',
            'name.min' => 'Nama perolehan minimal :min karakter!',
            'name.max' => 'Nama perolehan maksimal :max karakter!',

            'description.string' => 'Deskripsi perolehan harus berupa teks!',
        ];
    }
}
