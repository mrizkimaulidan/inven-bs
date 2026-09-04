<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Wire:target values that are always active for this table
     * (pagination, search, and per-page controls).
     */
    protected array $defaultTargets = [
        'resetFilters', 'perPage', 'search', 'nextPage', 'previousPage', 'gotoPage', '$refresh',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $targets,
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
     * Merge default targets with any additional targets passed from the parent.
     */
    public function resolvedTargets(): string
    {
        $mergedTargets = array_merge($this->defaultTargets, $this->targets);

        return implode(',', $mergedTargets);
    }
}
