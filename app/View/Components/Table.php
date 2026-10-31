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
    public const DEFAULT_TARGETS = [
        'resetFilters', 'perPage', 'search',
        'nextPage', 'previousPage', 'gotoPage',
        '$refresh',
    ];

    /**
     * Create a new component instance.
     *
     * @param  array  $targets  Additional Livewire actions to watch.
     * @param  LengthAwarePaginator|null  $paginator  The paginator instance.
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
     * Get the merged wire:target values as a comma-separated string.
     */
    public function resolvedTargets(): string
    {
        $targets = array_merge(self::DEFAULT_TARGETS, $this->targets);

        // Normalize to strings and drop empty values.
        $targets = array_filter(array_map('strval', $targets), fn ($t) => $t !== '');

        return implode(',', array_unique($targets));
    }
}
