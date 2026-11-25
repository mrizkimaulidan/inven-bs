<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render filter controls and report the number of active filters.
 */
class FilterAccordion extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $id  The accordion identifier.
     * @param  string  $title  The accordion title.
     * @param  int  $activeFiltersCount  The number of active filters.
     */
    public function __construct(
        public string $id,
        public string $title,
        public int $activeFiltersCount,
    ) {
        $this->activeFiltersCount = max(0, $this->activeFiltersCount);
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.filter-accordion');
    }
}
