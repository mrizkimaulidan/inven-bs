<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Page extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  bool  $searchable  Whether to show search controls
     * @param  array  $perPageOptions  Available options for per-page selector
     */
    public function __construct(
        public bool $searchable = false,
        public array $perPageOptions = [5, 10, 15, 20, 50, 100],
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page');
    }
}
