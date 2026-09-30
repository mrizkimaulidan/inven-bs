<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

class UpdateProfileForm extends Form
{
    /**
     * The user instance.
     */
    public User $user;

    /**
     * The name attribute.
     */
    public string $name = '';

    /**
     * The email attribute.
     */
    public string $email = '';

    /**
     * The current password attribute.
     */
    public string $current_password = '';

    /**
     * The new password attribute.
     */
    public string $password = '';

    /**
     * The new password confirmation attribute.
     */
    public string $password_confirmation = '';

    /**
     * Validate the input and persist the changes.
     */
    public function update(): void
    {
        $validated = $this->validate();

        unset(
            $validated['current_password'],
            $validated['password_confirmation'],
        );

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $this->user->update($validated);

        // Bersihkan field password setelah berhasil disimpan
        $this->reset('current_password', 'password', 'password_confirmation');
    }

    /**
     * Get the validation rules for the form.
     */
    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'current_password' => [
                'nullable',
                'required_with:password',
                'current_password:web',
            ],
            'password' => [
                'nullable',
                'required_with:current_password',
                Password::min(8),
            ],
            'password_confirmation' => [
                'nullable',
                'required_with:password',
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
            'name.required' => 'Nama lengkap wajib diisi!',
            'name.min' => 'Nama lengkap minimal :min karakter!',
            'name.max' => 'Nama lengkap maksimal :max karakter!',

            'email.required' => 'Alamat email wajib diisi!',
            'email.email' => 'Format alamat email tidak valid!',
            'email.max' => 'Alamat email maksimal :max karakter!',
            'email.unique' => 'Alamat email sudah digunakan!',

            'current_password.required_with' => 'Kata sandi sekarang wajib diisi untuk mengubah kata sandi!',
            'current_password.current_password' => 'Kata sandi sekarang tidak sesuai!',

            'password.required_with' => 'Kata sandi baru wajib diisi jika mengubah kata sandi!',
            'password.min' => 'Kata sandi baru minimal :min karakter!',

            'password_confirmation.required_with' => 'Konfirmasi kata sandi baru wajib diisi!',
            'password_confirmation.same' => 'Konfirmasi kata sandi baru tidak cocok!',
        ];
    }
}
