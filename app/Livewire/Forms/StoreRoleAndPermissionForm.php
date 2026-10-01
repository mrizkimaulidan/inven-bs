<?php

namespace App\Livewire\Forms;

use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class StoreRoleAndPermissionForm extends Form
{
    /**
     * The role name attribute.
     */
    public string $name = '';

    /**
     * The selected permission names.
     *
     * @var array<int, string>
     */
    public array $permissions = [];

    /**
     * Validate the input and persist a new role with its permissions.
     */
    public function store(): void
    {
        $validated = $this->validate();

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($validated['permissions']);
    }

    /**
     * Get the validation rules for the form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['string', 'exists:permissions,name'],
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
            'name.required' => 'Nama peran wajib diisi!',
            'name.string' => 'Nama peran harus berupa teks!',
            'name.min' => 'Nama peran minimal :min karakter!',
            'name.max' => 'Nama peran maksimal :max karakter!',
            'name.unique' => 'Nama peran sudah digunakan!',
            'permissions.required' => 'Hak akses wajib dipilih minimal satu!',
            'permissions.array' => 'Hak akses tidak valid!',
            'permissions.min' => 'Hak akses minimal :min dipilih!',
            'permissions.*.string' => 'Hak akses tidak valid!',
            'permissions.*.exists' => 'Hak akses tidak ditemukan!',
        ];
    }
}
