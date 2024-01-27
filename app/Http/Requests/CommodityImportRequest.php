<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommodityImportRequest extends FormRequest
{
    protected $errorBag = 'store';

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
            'file' => 'required|file|max:2048|mimes:xls,xlsx|extensions:xls,xlsx'
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
            'file.required' => 'Mohon pilih file untuk diunggah.',
            'file.file' => 'File yang diunggah tidak valid.',
            'file.max' => 'Ukuran file tidak boleh melebihi 2 megabit.',
            'file.mimes' => 'Silakan unggah file dengan format Excel yang valid (XLS atau XLSX).',
            'file.extensions' => 'Silakan unggah file dengan ekstensi yang valid (XLS atau XLSX).',
        ];
    }
}
