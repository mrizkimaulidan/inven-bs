<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a table empty state with search-aware title and guidance.
 */
class EmptyState extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string|null  $search  The active search query, if any.
     * @param  int  $colspan  The number of table columns the row spans.
     * @return void
     */
    public function __construct(
        public ?string $search = null,
        public int $colspan = 1,
    ) {
        /**
         * Keep the table cell span valid.
         */ if ($this->colspan < 1) {
            $this->colspan = 1;
        }
    }

    /**
     * Determine whether a search query is currently active.
     *
     * @return bool
     */
    public function hasSearch(): bool
    {
        return filled($this->search);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.empty-state');
    }
}
