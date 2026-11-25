<?php

namespace App\View\Components;

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
     *
     * @var list<string>
     */
    public const array DEFAULT_TARGETS = [
        'resetFilters',
        'perPage',
        'search',
        'nextPage',
        'previousPage',
        'gotoPage',
        '$refresh',
    ];

    /**
     * Create a new component instance.
     *
     * @param  list<string>  $targets  Additional Livewire actions to watch.
     * @param  LengthAwarePaginator<int, mixed>|null  $paginator  The paginator instance.
     */
    public function __construct(
        public array $targets = [],
        public ?LengthAwarePaginator $paginator = null,
    ) {}

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.table');
    }

    /**
     * Get the merged wire:target values as a comma-separated string.
     */
    public function resolvedTargets(): string
    {
        $targets = array_merge(self::DEFAULT_TARGETS, $this->targets);

        // Normalize target names and remove empty values.
        $normalized = array_values(array_unique(array_filter(
            array_map(
                static fn (mixed $target): string => is_scalar($target) ? trim((string) $target) : '',
                $targets,
            ),
            static fn (string $target): bool => $target !== '',
        )));

        return implode(',', $normalized);
    }
}
