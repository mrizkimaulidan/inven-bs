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
     * @param  bool  $searchable  Whether to show the search controls.
     * @param  array  $perPageOptions  Available options for the per-page selector.
     * @param  string  $searchProperty  Livewire property bound to the search input.
     * @param  string  $perPageProperty  Livewire property bound to the per-page selector.
     * @param  string  $searchPlaceholder  Placeholder text for the search input.
     */
    public function __construct(
        public bool $searchable = false,
        public array $perPageOptions = [5, 10, 15, 20, 50, 100],
        public string $searchProperty = 'search',
        public string $perPageProperty = 'perPage',
        public string $searchPlaceholder = 'Cari data',
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
