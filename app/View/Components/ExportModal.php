<?php

namespace App\View\Components;

use App\Enums\ExportFormat;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExportModal extends Component
{
    public array $options;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public int $totalRows,
    ) {
        $this->options = ExportFormat::options();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.export-modal');
    }
}
