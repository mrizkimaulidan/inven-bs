<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterAccordion extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $id  The accordion identifier
     * @param  string  $title  The accordion title
     * @param  int  $activeFiltersCount  The number of active filters
     */
    public function __construct(
        public string $id,
        public string $title,
        public int $activeFiltersCount,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-accordion');
    }
}
