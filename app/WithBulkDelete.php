<?php

namespace App;

/**
 * Provides bulk delete functionality driven by checkbox selection.
 *
 * The consuming component only needs to:
 * 1. Use this trait.
 * 2. Define a #[Computed] method that returns a LengthAwarePaginator
 *    and expose its name by overriding bulkPaginatorName().
 * 3. Optionally override bulkModelClass() to specify the model class
 *    (defaults to the paginator's model).
 *
 * Note: this trait assumes the host component uses Livewire\WithPagination.
 * It does NOT assume a $search property — reset the selection from the
 * component's own `updated()` hook when a filter property changes.
 *
 * Configuration is exposed via methods, not properties: Livewire only
 * hydrates public properties between requests, so protected properties
 * assigned once in mount() would silently reset to their declared
 * default on every subsequent request.
 */
trait WithBulkDelete
{
    /**
     * The IDs of the selected records.
     */
    public array $selected = [];

    /**
     * Indicates whether all records on the current page are selected.
     */
    public bool $selectAll = false;

    /**
     * The name of the computed property that returns the paginator.
     *
     * Override this in the consuming component if your paginator
     * is not named "items".
     */
    protected function bulkPaginatorName(): string
    {
        return 'items';
    }

    /**
     * The model class used for the bulk delete.
     *
     * Override this if the model differs from the paginator's model.
     */
    protected function bulkModelClass(): ?string
    {
        return null;
    }

    /**
     * Get the paginator instance for the current page.
     */
    protected function bulkPaginator(): mixed
    {
        return $this->{$this->bulkPaginatorName()};
    }

    /**
     * Get the IDs available on the current page.
     *
     * @return array<int, string>
     */
    protected function bulkPageIds(): array
    {
        return $this->bulkPaginator()
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->toArray();
    }

    /**
     * Resolve the model class used for the bulk delete.
     */
    protected function bulkModel(): string
    {
        if ($this->bulkModelClass()) {
            return $this->bulkModelClass();
        }

        $first = $this->bulkPaginator()->getCollection()->first();

        if ($first === null) {
            throw new \RuntimeException('Unable to resolve bulk model: the current page is empty.');
        }

        return $first::class;
    }

    /**
     * Handle the "select all" checkbox toggle.
     */
    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value ? $this->bulkPageIds() : [];
    }

    /**
     * Sync the "select all" state when an individual checkbox is toggled.
     */
    public function updatedSelected(): void
    {
        $pageIds = $this->bulkPageIds();

        $this->selectAll = count($this->selected) > 0
            && empty(array_diff($pageIds, $this->selected));
    }

    /**
     * Reset the selection whenever any paginator's page changes.
     *
     * Using the generic hook (rather than updatingPage()) so this
     * also works correctly if the host component ever uses a named
     * paginator (multiple paginators on one page).
     */
    public function updatingPaginators($page, $pageName): void
    {
        $this->resetSelection();
    }

    /**
     * Clear the current selection.
     */
    public function resetSelection(): void
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    /**
     * Remove the selected resources from storage.
     */
    public function destroySelected(): void
    {
        if (empty($this->selected)) {
            return;
        }

        $count = $this->bulkModel()::whereIn('id', $this->selected)->delete();

        $this->resetSelection();

        $this->dispatch('bulk-deleted', count: $count);
    }

    /**
     * Remove a single ID from the selection (useful for single-delete sync).
     */
    public function forgetSelected(int|string $id): void
    {
        $this->selected = array_values(
            array_filter($this->selected, fn ($selectedId) => (string) $selectedId !== (string) $id)
        );

        if (empty($this->selected)) {
            $this->selectAll = false;
        }
    }
}
