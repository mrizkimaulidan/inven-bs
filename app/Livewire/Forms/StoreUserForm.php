<?php

namespace App\Livewire\Forms;

use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;
use RuntimeException;

/**
 * Validate user details and create an account with its assigned role.
 */
class StoreUserForm extends Form
{
    use AuthorizesModulePermissions;

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
     * The password chosen for the account.
     */
    public string $password = '';

    /**
     * Confirmation of the chosen password.
     */
    public string $password_confirmation = '';

    /**
     * Validate the input and persist a new user record with its role.
     */
    public function store(): User
    {
        $this->authorizeModuleAction('tambah', 'pengguna');

        $this->name = trim($this->name);
        $this->email = strtolower(trim($this->email));

        $validated = $this->validate();

        /** @var Role $role */
        $role = Role::query()->with('permissions')->findOrFail($validated['role_id']);
        $this->ensureRoleIsAssignable($role);

        /** @var User $user */
        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->syncRoleWithLog($role);

        return $user;
    }

    /**
     * Ensure the authenticated user holds every permission granted by the target role.
     */
    private function ensureRoleIsAssignable(Role $role): void
    {
        $actor = auth()->user();

        if (! $actor instanceof User) {
            throw new RuntimeException('Authenticated user is not available.');
        }

        $rolePermissionNames = $role->permissions->pluck('name');
        $actorPermissionNames = $actor->getAllPermissions()->pluck('name');

        abort_if($rolePermissionNames->diff($actorPermissionNames)->isNotEmpty(), 403);
    }

    /**
     * Get the validation rules for the user form.
     *
     * @return array<string, list<string|Password>>
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
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                Password::min(8),
            ],
            'password_confirmation' => [
                'required',
                'string',
                'same:password',
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

            'password.required' => 'Kata sandi wajib diisi!',
            'password.string' => 'Kata sandi harus berupa teks!',
            'password.min' => 'Kata sandi minimal :min karakter!',

            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi!',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks!',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok!',
        ];
    }
}
