<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Wrap page content with alerts, search controls, pagination, and toolbar slots.
 */
class Page extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  bool  $searchable  Whether to show the search controls.
     * @param  list<int>  $perPageOptions  Available options for the per-page selector.
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
        $this->searchProperty = trim($this->searchProperty) !== '' ? trim($this->searchProperty) : 'search';
        $this->perPageProperty = trim($this->perPageProperty) !== '' ? trim($this->perPageProperty) : 'perPage';
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.page');
    }
}
