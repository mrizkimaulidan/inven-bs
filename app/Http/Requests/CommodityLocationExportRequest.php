<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommodityLocationExportRequest extends FormRequest
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
            'extension' => 'required|string|in:xlsx,xls,csv,html', // update the 'in:' validation if there is a new extension
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
            'extension.required' => 'Ekstensi harus dipilih!',
            'extension.string' => 'Ekstensi harus berupa karakter!',
            'extension.in' => 'Ekstensi yang dipilih tidak tersedia!',
        ];
    }
}
