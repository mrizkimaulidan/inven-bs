<?php

namespace App;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;

trait WithFilters
{
    /**
     * Count how many filters currently have a non-empty value.
     */
    #[Computed]
    public function activeFiltersCount(): int
    {
        return collect($this->filters)->filter(fn ($value) => filled($value))->count();
    }

    /**
     * Check if any filter is active.
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
     * Reset pagination whenever the search term changes.
     * Livewire automatically binds this via the updated{Property} convention.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination whenever any filter value changes,
     * including nested updates such as filters.condition or filters.brand.
     */
    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    /**
     * Apply the active filters to a query builder based on a given filter map.
     *
     * Supported map value formats:
     * - 'column_name'
     * - ['column' => 'column_name', 'cast' => 'int']
     * - ['scope' => 'scopeName', 'cast' => 'int']
     * - fn (Builder $query, mixed $value) => $query->...
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
     * Cast a raw filter value to the requested type.
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
