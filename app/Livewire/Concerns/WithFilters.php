<?php

namespace App\Livewire\Concerns;

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
 *
 * Note: this trait assumes the host component also uses
 * Livewire\WithPagination, since resetFilters() and updatedFilters()
 * below call $this->resetPage(). It does NOT assume a $search property —
 * reset pagination for that from the component's own `updated()` hook,
 * the same way as with WithBulkDelete.
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
     * @return void
     */
    protected function initializeFilters(array $defaults): void
    {
        $this->filters = array_merge($defaults, $this->filters);
    }

    /**
     * Get the number of filters that currently have a non-empty value.
     *
     * @return int
     */
    #[Computed]
    public function activeFiltersCount(): int
    {
        return collect($this->filters)->filter(fn ($filterValue) => filled($filterValue))->count();
    }

    /**
     * Determine if any filter is active.
     *
     * @return bool
     */
    #[Computed]
    public function hasActiveFilters(): bool
    {
        return $this->activeFiltersCount() > 0;
    }

    /**
     * Reset all filters back to an empty state (not back to the
     * defaults passed to initializeFilters()) and return to page 1.
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->reset('filters');
        $this->resetPage();
    }

    /**
     * Reset pagination when any filter value changes.
     *
     * @return void
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
     * - fn (Builder $query, mixed $filterValue) => $query->...
     *
     * Closures are self-contained and are not passed through
     * `castFilterValue()`; if a closure needs a typed value, it is
     * responsible for casting it itself.
     *
     * @param  Builder  $query
     * @param  array<string, string|array|Closure>  $filterMap
     * @return Builder
     */
    protected function applyFilters(Builder $query, array $filterMap): Builder
    {
        foreach ($filterMap as $filterKey => $definition) {
            $filterValue = $this->filters[$filterKey] ?? null;

            if (blank($filterValue)) {
                continue;
            }

            if ($definition instanceof Closure) {
                $definition($query, $filterValue);

                continue;
            }

            if (is_string($definition)) {
                $definition = ['column' => $definition];
            }

            $castValue = $this->castFilterValue($filterValue, $definition['cast'] ?? null);

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
     *
     * @param  mixed  $value
     * @param  ?string  $cast
     * @return mixed
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
