<?php

namespace App\Livewire\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

/**
 * Provide a declarative, URL-synced filtering system for Livewire table components.
 *
 * Requirements:
 * - The host component should use `Livewire\WithPagination`, as `resetFilters()` and
 *   `updatedFilters()` invoke `$this->resetPage()`.
 * - Standalone properties (such as `$search`) are intentionally excluded and should
 *   reset pagination inside the host component's `updated()` lifecycle hook.
 *
 * Usage:
 * ```php
 * use App\Livewire\Concerns\WithFilters;
 * use Illuminate\Database\Eloquent\Builder;
 * use Livewire\Attributes\Computed;
 * use Livewire\Component;
 * use Livewire\WithPagination;
 *
 * class UsersTable extends Component
 * {
 *     use WithFilters;
 *     use WithPagination;
 *
 *     public function mount(): void
 *     {
 *         $this->initializeFilters([
 *             'status' => '',
 *             'role' => '',
 *         ]);
 *     }
 *
 *     protected function filterMap(): array
 *     {
 *         return [
 *             // Direct column match
 *             'status' => 'status',
 *
 *             // Column match with type casting
 *             'department_id' => ['column' => 'department_id', 'cast' => 'int'],
 *
 *             // Eloquent query scope with type casting
 *             'verified' => ['scope' => 'verified', 'cast' => 'bool'],
 *
 *             // Custom closure constraint (e.g., Spatie role relation)
 *             'role' => fn (Builder $query, mixed $value): Builder =>$query->whereHas(
 *                 'roles',
 *                 fn (Builder $q): Builder => is_numeric($value)
 *                     ? $q->whereKey((int)$value)
 *                     : $q->where('name', (string)$value)
 *             ),
 *         ];
 *     }
 *
 *     #[Computed]
 *     public function records()
 *     {
 *         return $this->applyFilters(User::query(),$this->filterMap())
 *             ->latest()
 *             ->paginate(15);
 *     }
 * }
 * ```
 */
trait WithFilters
{
    /**
     * The active filter values synced with the URL query string, keyed by filter name.
     *
     * @var array<string, mixed>
     */
    #[Url]
    public array $filters = [];

    /**
     * The initial default filter structure used when resetting filters.
     *
     * @var array<string, mixed>
     */
    protected array $defaultFilters = [];

    /**
     * Initialize default filter keys without overwriting values already hydrated from the URL.
     *
     * @param  array<string, mixed>  $defaults
     */
    protected function initializeFilters(array $defaults): void
    {
        $this->defaultFilters = $defaults;
        $this->filters = array_merge($defaults, $this->filters);
    }

    /**
     * Get the total number of filters that currently hold a non-empty value.
     */
    #[Computed]
    public function activeFiltersCount(): int
    {
        return collect($this->filters)
            ->filter(fn (mixed $value): bool => filled($value))
            ->count();
    }

    /**
     * Determine whether at least one filter is currently active.
     */
    #[Computed]
    public function hasActiveFilters(): bool
    {
        return $this->activeFiltersCount > 0;
    }

    /**
     * Restore all filters back to their initialized default state and reset pagination.
     */
    public function resetFilters(): void
    {
        $this->filters = $this->defaultFilters;
        $this->resetPage();
    }

    /**
     * Reset pagination to the first page whenever any filter value changes.
     */
    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    /**
     * Apply all non-empty active filters to the given Eloquent query builder.
     *
     * Supported definition formats in `$filterMap`:
     * - `'column_name'`
     * - `['column' => 'column_name', 'cast' => 'int']`
     * - `['scope' => 'scopeName', 'cast' => 'int']`
     * - `fn (Builder $query, mixed $value) => $query->...`
     *
     * Note: Closures receive raw `$filterValue` and are responsible for their own casting.
     *
     * @param  array<string, string|array{column?: string, scope?: string, cast?: string}|Closure>  $filterMap
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
     * Cast a scalar or array filter value into the specified primitive type.
     */
    protected function castFilterValue(mixed $value, ?string $cast): mixed
    {
        if (is_array($value)) {
            return array_map(
                fn (mixed $item): mixed => $this->castFilterValue($item, $cast),
                $value
            );
        }

        return match ($cast) {
            'int' => (int) $value,
            'float' => (float) $value,
            'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'string' => (string) $value,
            default => $value,
        };
    }
}
