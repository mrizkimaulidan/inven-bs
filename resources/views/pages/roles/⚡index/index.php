<?php

use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithModal;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Provide the roles listing, filters, pagination, and record actions.
 */
new #[Title('Halaman Daftar Peran & Hak Akses')] class extends Component
{
    use WithBulkDelete, WithModal, WithPagination;

    /**
     * The number of items to display per page.
     */
    #[Url(as: 'per_page')]
    public int $perPage = 5;

    /**
     * The search query string.
     */
    #[Url]
    public string $search = '';

    /**
     * Get a listing of the resource with pagination.
     *
     * @return LengthAwarePaginator<int, Role>
     */
    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        $perPage = max(1, $this->perPage);
        $keyword = trim($this->search);

        $query = Role::query()->withCount(['permissions', 'users']);

        $query->when($keyword !== '', static function (Builder $query) use ($keyword): void {
            $query->whereAny(['name'], 'like', "%{$keyword}%");
        });

        return $query->paginate($perPage);
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     */
    protected function bulkPaginatorName(): string
    {
        return 'roles';
    }

    /**
     * Get the destination after a successful bulk delete.
     */
    protected function bulkRedirectPath(): ?string
    {
        return route('peran-dan-hak-akses.index');
    }

    /**
     * Get the permission module name used by bulk delete actions.
     */
    protected function bulkPermissionModule(): string
    {
        return 'peran';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): void
    {
        $this->authorizeModuleAction('hapus', 'peran');

        $role->delete();

        session()->flash('success', 'Peran berhasil dihapus.');

        $this->redirect(route('peran-dan-hak-akses.index'), navigate: true);
    }

    /**
     * Reset pagination and selection state when filter or page-size properties change.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'], true)) {
            $this->resetPage();
        }

        if ($property === 'search') {
            $this->resetSelection();
        }
    }
};
