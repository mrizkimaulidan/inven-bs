<?php

namespace App\Livewire\Forms;

use App\Enums\ExportFormat;
use Illuminate\Validation\Rule;
use Livewire\Form;

/**
 * Validate spreadsheet format choices and build dated export filenames.
 */
class ExportForm extends Form
{
    /**
     * The selected export format value.
     */
    public string $format = ExportFormat::Xlsx->value;

    /**
     * Get the validation rules for the form.
     *
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'format' => ['required', Rule::enum(ExportFormat::class)],
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
            'format.required' => 'Format file wajib dipilih.',
            'format.enum' => 'Format file yang dipilih tidak valid.',
        ];
    }

    /**
     * Resolve the current format as an ExportFormat enum instance.
     */
    public function formatEnum(): ExportFormat
    {
        return ExportFormat::tryFrom($this->format) ?? ExportFormat::Xlsx;
    }

    /**
     * Build the dated export filename for the given prefix.
     */
    public function filename(string $prefix = 'data'): string
    {
        return sprintf('%s (%s).%s', $prefix, now()->format('d-m-Y'), $this->formatEnum()->value);
    }
}
