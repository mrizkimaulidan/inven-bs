<?php

namespace App\View\Components;

use App\Enums\ExportFormat;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Provide export row counts and format options to the export view.
 */
class ExportModal extends Component
{
    public array $options;

    /**
     * Create a new component instance.
     *
     * @param  string  $title
     * @param  int  $totalRows
     * @return void
     */
    public function __construct(
        public string $title,
        public int $totalRows,
    ) {
        $this->options = ExportFormat::options();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.export-modal');
    }
}
