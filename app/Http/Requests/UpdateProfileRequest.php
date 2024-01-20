<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    protected $errorBag = 'update';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users,email,' . auth()->user()->id . '|min:3|max:255',
            'password' => 'nullable|string|min:3|max:255',
            'password_confirmation' => 'nullable|string|required_if:password,!=,""|same:password|min:3|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kolom nama lengkap wajib diisi!',
            'name.string' => 'Kolom nama lengkap harus berupa karakter!',
            'name.min' => 'Kolom nama lengkap minimal :min karakter!',
            'name.max' => 'Kolom nama lengkap maksimal :max karakter!',

            'email.required' => 'Kolom alamat email wajib diisi!',
            'email.string' => 'Kolom alamat email harus berupa karakter!',
            'email.email' => 'Alamat email tidak valid!',
            'email.unique' => 'Alamat email sudah digunakan!',
            'email.min' => 'Kolom alamat email minimal :min karakter!',
            'email.max' => 'Kolom alamat email maksimal :max karakter!',

            'password.required' => 'Kolom kata sandi wajib diisi!',
            'password.string' => 'Kolom kata sandi harus berupa karakter!',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok!',
            'password.min' => 'Kolom kata sandi minimal :min karakter!',
            'password.max' => 'Kolom kata sandi maksimal :max karakter!',

            'password_confirmation.required' => 'Kolom konfirmasi kata sandi wajib diisi!',
            'password_confirmation.string' => 'Kolom konfirmasi kata sandi harus berupa karakter!',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok!',
            'password_confirmation.min' => 'Kolom konfirmasi kata sandi minimal :min karakter!',
            'password_confirmation.max' => 'Kolom konfirmasi kata sandi maksimal :max karakter!',
        ];
    }
}
