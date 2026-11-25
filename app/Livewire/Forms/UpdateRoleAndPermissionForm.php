<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Livewire\Form;
use RuntimeException;

/**
 * Validate role changes and synchronize the role's assigned permissions.
 */
class UpdateRoleAndPermissionForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The role model instance being updated.
     */
    public ?Role $role = null;

    /**
     * The role name provided by the user.
     */
    public string $name = '';

    /**
     * The selected permission names.
     *
     * @var array<int, string>
     */
    public array $permissions = [];

    /**
     * Validate the input and persist changes to the role and its permissions.
     */
    public function update(): void
    {
        $this->authorizeModuleAction('ubah', 'peran');

        if (! $this->role instanceof Role) {
            throw new RuntimeException('Role model must be loaded before updating.');
        }

        $actor = auth()->user();

        if (! $actor instanceof User) {
            throw new RuntimeException('Authenticated user is not available.');
        }

        $this->name = trim($this->name);
        $validated = $this->validate();

        $assignablePermissions = $actor->getAllPermissions()
            ->pluck('name')
            ->merge($this->role->permissions()->pluck('name'));

        abort_if(collect($validated['permissions'])->diff($assignablePermissions)->isNotEmpty(), 403);

        $this->role->update([
            'name' => $validated['name'],
        ]);

        $this->role->syncPermissionsWithLog($validated['permissions']);
    }

    /**
     * Get the validation rules for the role update form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        $ignoreId = $this->role?->id;

        return [
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('roles', 'name')->ignore($ignoreId)],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['string', 'exists:permissions,name'],
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
