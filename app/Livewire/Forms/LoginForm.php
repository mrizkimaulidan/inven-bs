<?php

namespace App\Livewire\Forms;

use Livewire\Form;

/**
 * Validate login credentials submitted through the Livewire login form.
 */
class LoginForm extends Form
{
    /**
     * The user's email address.
     */
    public string $email = '';

    /**
     * The user's password.
     */
    public string $password = '';

    /**
     * Whether to keep the user's session remembered.
     */
    public bool $remember = false;

    /**
     * Get the validation rules for the login form.
     *
     * @return array<string, list<string>>
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
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
            'email.required' => 'Alamat email wajib diisi!',
            'email.email' => 'Format alamat email tidak valid!',
            'email.max' => 'Alamat email maksimal 255 karakter!',
            'password.required' => 'Kata sandi wajib diisi!',
        ];
    }
}
