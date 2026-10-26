<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class UpdateUserForm extends Form
{
    /**
     * The user instance.
     */
    public User $user;

    /**
     * The selected role ID.
     */
    public int $role_id = 0;

    /**
     * The user's name.
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
     * Validate the input and persist the changes.
     */
    public function update(): User
    {
        $validated = $this->validate();

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }

        $this->user->update($userData);

        $role = Role::findOrFail($this->role_id);

        $this->user->syncRoles($role);

        return $this->user;
    }

    /**
     * Get the validation rules for the form.
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
     * Get the custom validation messages.
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
