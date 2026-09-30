<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
    public string $new_password = '';

    /**
     * The new password confirmation attribute.
     */
    public string $new_password_confirmation = '';

    /**
     * Validate the input and persist the changes.
     */
    public function update(): void
    {
        $validated = $this->validate();

        // Hanya update password jika field new_password diisi
        if (! empty($validated['new_password'])) {
            $validated['password'] = Hash::make($validated['new_password']);
        }

        // Hapus field yang bukan kolom di tabel users
        unset(
            $validated['current_password'],
            $validated['new_password'],
            $validated['new_password_confirmation'],
        );

        $this->user->update($validated);

        // Bersihkan field password setelah berhasil disimpan
        $this->reset('current_password', 'new_password', 'new_password_confirmation');
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
                'required_with:new_password',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ($value && ! Hash::check($value, $this->user->password)) {
                        $fail('Kata sandi sekarang tidak sesuai!');
                    }
                },
            ],
            'new_password' => [
                'nullable',
                'min:8',
                'max:255',
                'same:new_password_confirmation',
            ],
            'new_password_confirmation' => [
                'nullable',
                'min:8',
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

            'new_password.min' => 'Kata sandi baru minimal :min karakter!',
            'new_password.max' => 'Kata sandi baru maksimal :max karakter!',
            'new_password.same' => 'Konfirmasi kata sandi baru tidak cocok!',

            'new_password_confirmation.min' => 'Konfirmasi kata sandi minimal :min karakter!',
        ];
    }
}
