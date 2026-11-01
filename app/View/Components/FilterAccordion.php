<?php

namespace App\View\Components;

use Closure;
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
     * @param  string  $id  The accordion identifier
     * @param  string  $title  The accordion title
     * @param  int  $activeFiltersCount  The number of active filters
     * @return void
     */
    public function __construct(
        public string $id,
        public string $title,
        public int $activeFiltersCount,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-accordion');
    }
}
