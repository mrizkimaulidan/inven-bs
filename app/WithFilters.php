<?php

namespace App;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

/**
 * Provide a declarative filtering system for Livewire table components.
 *
 * Usage:
 * 1. Define the shape of `$filters` in the consuming component's `mount()`,
 *    preferably via `initializeFilters()` so URL-bound values are not
 *    clobbered on first load.
 * 2. Implement a `filterMap()` method describing how each filter key maps
 *    to a query constraint.
 * 3. Call `$this->applyFilters($query, $this->filterMap())` when building
 *    the filtered query.
 */
trait WithFilters
{
    /**
     * The active filter values, keyed by filter name.
     */
    #[Url]
    public array $filters = [];

    /**
     * Merge the given default filter keys into `$filters` without overwriting
     * values already hydrated from the URL query string.
     *
     * @param  array<string, mixed>  $defaults
     */
    protected function initializeFilters(array $defaults): void
    {
        $this->filters = array_merge($defaults, $this->filters);
    }

    /**
     * Get the number of filters that currently have a non-empty value.
     */
    #[Computed]
    public function activeFiltersCount(): int
    {
        return collect($this->filters)->filter(fn ($value) => filled($value))->count();
    }

    /**
     * Determine if any filter is active.
     */
    #[Computed]
    public function hasActiveFilters(): bool
    {
        return $this->activeFiltersCount() > 0;
    }

    /**
     * Reset all active filters and return to the first page.
     */
    public function resetFilters(): void
    {
        $this->reset('filters');
        $this->resetPage();
    }

    /**
     * Reset pagination when the search term changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when any filter value changes.
     */
    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    /**
     * Apply the active filters to the given query builder.
     *
     * Supported map value formats:
     * - 'column_name'
     * - ['column' => 'column_name', 'cast' => 'int']
     * - ['scope' => 'scopeName', 'cast' => 'int']
     * - fn (Builder $query, mixed $value) => $query->...
     *
     * Closures are self-contained and are not passed through
     * `castFilterValue()`; if a closure needs a typed value, it is
     * responsible for casting it itself.
     *
     * @param  array<string, string|array|Closure>  $filterMap
     */
    protected function applyFilters(Builder $query, array $filterMap): Builder
    {
        foreach ($filterMap as $filterKey => $definition) {
            $value = $this->filters[$filterKey] ?? null;

            if (blank($value)) {
                continue;
            }

            if ($definition instanceof Closure) {
                $definition($query, $value);

                continue;
            }

            if (is_string($definition)) {
                $definition = ['column' => $definition];
            }

            $castValue = $this->castFilterValue($value, $definition['cast'] ?? null);

            if (isset($definition['scope'])) {
                $query->{$definition['scope']}($castValue);

                continue;
            }

            $query->where($definition['column'], $castValue);
        }

        return $query;
    }

    /**
     * Cast the given filter value to the requested type.
     */
    protected function castFilterValue(mixed $value, ?string $cast): mixed
    {
        return match ($cast) {
            'int' => (int) $value,
            'float' => (float) $value,
            'bool' => (bool) $value,
            default => $value,
        };
    }
}
