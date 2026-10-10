<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

class StoreUserForm extends Form
{
    /**
     * The role attribute.
     */
    public int $role_id = 0;

    /**
     * The name attribute.
     */
    public string $name = '';

    /**
     * The email attribute.
     */
    public string $email = '';

    /**
     * The password attribute.
     */
    public string $password = '';

    /**
     * The password confirmation attribute.
     */
    public string $password_confirmation = '';

    /**
     * Validate the input and persist a new record.
     */
    public function store(): User
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->assignRole($this->role_id);

        return $user;
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

            'password.required' => 'Kata sandi wajib diisi!',
            'password.string' => 'Kata sandi harus berupa teks!',
            'password.min' => 'Kata sandi minimal :min karakter!',

            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi!',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks!',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok!',
        ];
    }
}
