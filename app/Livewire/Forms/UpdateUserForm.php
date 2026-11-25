<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;
use RuntimeException;

/**
 * Validate user changes and synchronize the user's assigned role.
 */
class UpdateUserForm extends Form
{
    use AuthorizesModulePermissions;

    /**
     * The user model instance being updated.
     */
    public User $user;

    /**
     * The selected role ID.
     */
    public int $role_id = 0;

    /**
     * The user's full name.
     */
    public string $name = '';

    /**
     * The user's email address.
     */
    public string $email = '';

    /**
     * The new password for the account.
     */
    public string $password = '';

    /**
     * Confirmation of the new password.
     */
    public string $password_confirmation = '';

    /**
     * Validate the input and persist changes to the user record and role.
     */
    public function update(): User
    {
        $this->authorizeModuleAction('ubah', 'pengguna');

        $this->name = trim($this->name);
        $this->email = strtolower(trim($this->email));

        $validated = $this->validate();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        $currentRoleId = $this->user->roles()->value('roles.id');
        $roleToAssign = null;

        if ((int) $this->role_id !== (int) $currentRoleId) {
            $actor = auth()->user();

            if (! $actor instanceof User) {
                throw new RuntimeException('Authenticated user is not available.');
            }

            /** @var Role $roleToAssign */
            $roleToAssign = Role::query()->with('permissions')->findOrFail($this->role_id);
            $rolePermissionNames = $roleToAssign->permissions->pluck('name');
            $actorPermissionNames = $actor->getAllPermissions()->pluck('name');

            abort_if($rolePermissionNames->diff($actorPermissionNames)->isNotEmpty(), 403);
        }

        if ($this->password !== '') {
            $userData['password'] = $this->password;
        }

        $this->user->update($userData);

        if ($roleToAssign !== null) {
            $this->user->syncRoleWithLog($roleToAssign);
        }

        return $this->user;
    }

    /**
     * Get the validation rules for the user update form.
     *
     * @return array<string, list<mixed>>
     */
    protected function rules(): array
    {
        return [
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'password' => [
                'nullable',
                'string',
                Password::min(8),
                'confirmed',
            ],
            'password_confirmation' => [
                'nullable',
                'string',
            ],
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
            'role_id.required' => 'Peran wajib dipilih!',
            'role_id.integer' => 'Peran tidak valid!',
            'role_id.exists' => 'Peran yang dipilih tidak terdaftar!',

            'name.required' => 'Nama lengkap wajib diisi!',
            'name.string' => 'Nama lengkap harus berupa teks!',
            'name.min' => 'Nama lengkap minimal :min karakter!',
            'name.max' => 'Nama lengkap maksimal :max karakter!',

            'email.required' => 'Alamat email wajib diisi!',
            'email.string' => 'Alamat email harus berupa teks!',
            'email.email' => 'Format alamat email tidak valid!',
            'email.max' => 'Alamat email maksimal :max karakter!',
            'email.unique' => 'Alamat email sudah terdaftar!',

            'password.min' => 'Kata sandi minimal :min karakter!',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok!',
        ];
    }
}
