<?php

namespace App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use LogicException;
use RuntimeException;

/**
 * Provide bulk delete functionality driven by checkbox selection in Livewire components.
 *
 * Requirements & usage:
 * 1. Use this trait alongside `Livewire\WithPagination` and `WithModal`.
 * 2. Define a `#[Computed]` property returning a paginator and expose its name via `bulkPaginatorName()`.
 * 3. Implement `bulkPermissionModule()` to define the permission module name.
 * 4. Optionally override `bulkModelClass()`, `bulkRedirectPath()`, or `bulkRecordLabelColumn()`.
 *
 * Configuration is exposed via methods rather than properties so values are not reset
 * between Livewire requests.
 */
trait WithBulkDelete
{
    use AuthorizesModulePermissions;

    /**
     * The IDs of the currently selected records.
     *
     * @var list<string>
     */
    public array $selected = [];

    /**
     * Indicates whether all records on the current page are selected.
     */
    public bool $selectAll = false;

    /**
     * Get the name of the computed property that returns the paginator.
     */
    protected function bulkPaginatorName(): string
    {
        return 'items';
    }

    /**
     * Get the model class used for bulk delete operations.
     */
    protected function bulkModelClass(): ?string
    {
        return null;
    }

    /**
     * Get the URL to redirect to after a successful bulk delete.
     */
    protected function bulkRedirectPath(): ?string
    {
        return null;
    }

    /**
     * Get the column name used when fetching summary labels for selected records.
     */
    protected function bulkRecordLabelColumn(): string
    {
        return 'name';
    }

    /**
     * Get the permission module name used to authorize bulk delete actions.
     */
    protected function bulkPermissionModule(): string
    {
        throw new LogicException('The bulk permission module must be defined by the consuming component.');
    }

    /**
     * Get the paginator instance for the current page.
     */
    protected function bulkPaginator(): mixed
    {
        return $this->{$this->bulkPaginatorName()};
    }

    /**
     * Get all record IDs available on the current paginator page.
     *
     * @return list<string>
     */
    protected function bulkPageIds(): array
    {
        return $this->bulkPaginator()
            ->pluck('id')
            ->map(static fn (mixed $recordId): string => (string) $recordId)
            ->values()
            ->all();
    }

    /**
     * Get the selected records from the current page for confirmation display.
     *
     * @return Collection<int, Model>
     */
    #[Computed]
    public function selectedRecords(): Collection
    {
        $selectedRecordIds = array_intersect($this->selected, $this->bulkPageIds());

        if ($selectedRecordIds === []) {
            return new Collection;
        }

        $modelClass = $this->bulkModel();
        $labelColumn = $this->bulkRecordLabelColumn();

        return $modelClass::query()
            ->whereIn('id', $selectedRecordIds)
            ->get(['id', $labelColumn]);
    }

    /**
     * Resolve the Eloquent model class used for bulk delete operations.
     *
     * @return class-string<Model>
     */
    protected function bulkModel(): string
    {
        $configuredModel = $this->bulkModelClass();

        if ($configuredModel !== null) {
            /** @var class-string<Model> $configuredModel */
            return $configuredModel;
        }

        $firstModel = $this->bulkPaginator()->getCollection()->first();

        if (! $firstModel instanceof Model) {
            throw new RuntimeException('Unable to resolve bulk model: the current page is empty.');
        }

        return $firstModel::class;
    }

    /**
     * Handle toggling the "select all" checkbox for the current page.
     */
    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value ? $this->bulkPageIds() : [];
    }

    /**
     * Synchronize the "select all" state when individual checkboxes change.
     */
    public function updatedSelected(): void
    {
        $pageIds = $this->bulkPageIds();
        $selectedOnPage = array_intersect($pageIds, $this->selected);

        $this->selectAll = $pageIds !== []
            && count($selectedOnPage) === count($pageIds);
    }

    /**
     * Reset selection whenever any paginator page changes.
     */
    public function updatingPaginators(mixed $page, string $pageName): void
    {
        $this->resetSelection();
    }

    /**
     * Clear the current record selection and "select all" flag.
     */
    public function resetSelection(): void
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    /**
     * Open the shared bulk-delete confirmation modal after authorizing the action.
     */
    #[On('showBulkDeleteConfirmationModal')]
    public function showBulkDeleteConfirmation(): void
    {
        $this->authorizeModuleAction('hapus', $this->bulkPermissionModule());

        $this->selected = array_values(array_intersect($this->selected, $this->bulkPageIds()));

        if ($this->selected === []) {
            return;
        }

        $this->showModal('bulk-destroy');
    }

    /**
     * Confirm and execute bulk deletion from the confirmation modal.
     */
    #[On('confirmBulkDelete')]
    public function confirmBulkDelete(): void
    {
        $this->authorizeModuleAction('hapus', $this->bulkPermissionModule());

        $this->destroySelected();
        $this->closeModal();
    }

    /**
     * Delete the currently selected records on the active page.
     */
    public function destroySelected(): void
    {
        $this->authorizeModuleAction('hapus', $this->bulkPermissionModule());

        $selectedRecordIds = array_intersect($this->selected, $this->bulkPageIds());

        if ($selectedRecordIds === []) {
            return;
        }

        $deletedCount = $this->bulkModel()::query()
            ->whereIn('id', $selectedRecordIds)
            ->delete();

        $this->resetSelection();

        if ($deletedCount > 0) {
            session()->flash('success', "{$deletedCount} data terpilih berhasil dihapus.");
        }

        if ($deletedCount > 0 && $this->bulkRedirectPath() !== null) {
            $this->redirect($this->bulkRedirectPath(), navigate: true);
        }
    }
}
