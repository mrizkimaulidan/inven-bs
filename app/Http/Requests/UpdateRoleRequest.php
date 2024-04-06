<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    protected $errorBag = 'update';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'permissions' => 'required|array'
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
            'name.required' => 'Kolom nama peran wajib diisi!',
            'name.string' => 'Kolom nama peran harus berupa karakter!',
            'name.min' => 'Kolom nama peran minimal :min karakter!',
            'name.max' => 'Kolom nama peran maksimal :max karakter!',

            'permissions.required' => 'Kolom hak akses wajib diisi!',
            'permissions.array' => 'Tipe data hak akses tidak valid!'
        ];
    }
}
