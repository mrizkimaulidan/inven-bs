<?php

namespace App\Livewire\Forms;

use Livewire\Form;

/**
 * Validate login credentials.
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
     * Whether to remember the user.
     */
    public bool $remember = false;

    /**
     * Get the validation rules for the form.
     *
     * @return array
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
     * Get the custom validation messages.
     *
     * @return array
     */
    protected function messages(): array
    {
        return [
            'email.required' => 'Alamat email wajib diisi!',
            'email.email' => 'Format alamat email tidak valid!',
            'password.required' => 'Kata sandi wajib diisi!',
        ];
    }
}
