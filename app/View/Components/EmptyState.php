<?php

namespace App\View\Components;

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
     */
    public function __construct(
        public ?string $search = null,
        public int $colspan = 1,
    ) {
        // Keep the table cell span valid.
        if ($this->colspan < 1) {
            $this->colspan = 1;
        }
    }

    /**
     * Determine whether a search query is currently active.
     */
    public function hasSearch(): bool
    {
        return is_string($this->search) && trim($this->search) !== '';
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.empty-state');
    }
}
