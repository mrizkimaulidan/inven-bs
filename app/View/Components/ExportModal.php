<?php

namespace App\View\Components;

use App\Enums\ExportFormat;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Provide export row counts and format options to the export view.
 */
class ExportModal extends Component
{
    /**
     * Available export format options.
     *
     * @var list<ExportFormat>
     */
    public array $options;

    /**
     * Create a new component instance.
     *
     * @param  string  $title  The modal dialog heading.
     * @param  int  $totalRows  The number of rows eligible for export.
     */
    public function __construct(
        public string $title,
        public int $totalRows,
    ) {
        $this->totalRows = max(0, $this->totalRows);
        $this->options = array_values(ExportFormat::options());
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.export-modal');
    }
}
