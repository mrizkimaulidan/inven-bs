<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

/**
 * Validate profile changes and persist them for the current user.
 */
class UpdateProfileForm extends Form
{
    /**
     * The user model instance being updated.
     */
    public ?User $user = null;

    /**
     * The user's full name.
     */
    public string $name = '';

    /**
     * The user's email address.
     */
    public string $email = '';

    /**
     * The current password for verification.
     */
    public string $current_password = '';

    /**
     * The new password for the account.
     */
    public string $password = '';

    /**
     * Confirmation of the new password.
     */
    public string $password_confirmation = '';

    /**
     * Validate the input and persist changes to the user profile.
     */
    public function update(): void
    {
        if (! $this->user instanceof User) {
            return;
        }

        $this->name = trim($this->name);
        $this->email = strtolower(trim($this->email));

        $validated = $this->validate();

        unset(
            $validated['current_password'],
            $validated['password_confirmation'],
        );

        if ($validated['password'] !== '' && $validated['password'] !== null) {
            $validated['password'] = Hash::make((string) $validated['password']);
        } else {
            unset($validated['password']);
        }

        $this->user->update($validated);

        // Clear sensitive password fields after a successful update.
        $this->reset('current_password', 'password', 'password_confirmation');
    }

    /**
     * Get the validation rules for the profile form.
     *
     * @return array<string, list<mixed>>
     */
    protected function rules(): array
    {
        $ignoreId = $this->user?->id;

        return [
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
                Rule::unique('users', 'email')->ignore($ignoreId),
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
     * Get the custom validation messages in Indonesian.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi!',
            'name.string' => 'Nama lengkap harus berupa teks!',
            'name.min' => 'Nama lengkap minimal :min karakter!',
            'name.max' => 'Nama lengkap maksimal :max karakter!',

            'email.required' => 'Alamat email wajib diisi!',
            'email.string' => 'Alamat email harus berupa teks!',
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
