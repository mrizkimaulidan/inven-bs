<?php

namespace App\Livewire\Forms;

use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

/**
 * Validate and hold spreadsheet files submitted for import.
 */
class ImportForm extends Form
{
    /**
     * The spreadsheet uploaded by the user.
     *
     * @var TemporaryUploadedFile|null
     */
    public ?TemporaryUploadedFile $spreadsheetFile = null;

    /**
     * Get the validation rules for the form.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'spreadsheetFile' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'spreadsheetFile.required' => 'File spreadsheet wajib dipilih.',
            'spreadsheetFile.file' => 'File yang dipilih tidak valid.',
            'spreadsheetFile.mimes' => 'File harus berformat XLSX, XLS, atau CSV.',
            'spreadsheetFile.max' => 'Ukuran file maksimal 10 MB.',
        ];
    }
}
