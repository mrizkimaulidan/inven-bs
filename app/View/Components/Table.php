<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * The default wire:target values for the table.
     */
    protected array $defaultTargets = [
        'resetFilters', 'perPage', 'search', 'nextPage', 'previousPage', 'gotoPage', '$refresh',
    ];

    /**
     * Create a new component instance.
     *
     * @param  array  $targets  The additional wire:target values
     * @param  LengthAwarePaginator|null  $paginator  The paginator instance
     */
    public function __construct(
        public array $targets = [],
        public ?LengthAwarePaginator $paginator = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }

    /**
     * Get the merged wire:target values.
     */
    public function resolvedTargets(): string
    {
        return implode(',', array_merge($this->defaultTargets, $this->targets));
    }
}
