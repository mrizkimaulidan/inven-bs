<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render table sections, loading state, and optional pagination.
 */
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
     * @return void
     */
    public function __construct(
        public array $targets = [],
        public ?LengthAwarePaginator $paginator = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }

    /**
     * Get the merged wire:target values as a comma-separated string.
     *
     * @return string
     */
    public function resolvedTargets(): string
    {
        $targets = array_merge(self::DEFAULT_TARGETS, $this->targets);

        /**
         * Normalize target names and remove empty values.
         */ $targets = array_filter(array_map('strval', $targets), fn ($target) => $target !== '');

        return implode(',', array_unique($targets));
    }
}
