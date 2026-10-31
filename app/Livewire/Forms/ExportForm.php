<?php

namespace App\Livewire\Forms;

use App\Enums\ExportFormat;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ExportForm extends Form
{
    /**
     * The selected export format.
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
     * Resolve the current format as an enum instance.
     */
    public function formatEnum(): ExportFormat
    {
        return ExportFormat::from($this->format);
    }

    /**
     * Build the export filename.
     */
    public function filename(string $prefix = 'data'): string
    {
        return sprintf('%s (%s).%s', $prefix, now()->format('d-m-Y'), $this->format);
    }
}
