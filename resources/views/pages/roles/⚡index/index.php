<?php

use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

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
     * @return LengthAwarePaginator
     */
    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        $query = Role::query()->with('permissions')->withCount('permissions', 'users');

        $query->when(filled($this->search), function (Builder $query) {
            $query->whereAny(['name'], 'like', "%$this->search%");
        });

        return $query->paginate($this->perPage);
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     *
     * @return string
     */
    protected function bulkPaginatorName(): string
    {
        return 'roles';
    }

    /**
     * Get the destination after a successful bulk delete.
     *
     * @return ?string
     */
    protected function bulkRedirectPath(): ?string
    {
        return '/peran-dan-hak-akses';
    }

    protected function bulkPermissionModule(): string
    {
        return 'peran';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return void
     */
    public function destroy(Role $role): void
    {
        $this->authorizeModuleAction('hapus', 'peran');

        $role->delete();

        session()->flash('success', 'Peran berhasil dihapus.');

        $this->redirect('/peran-dan-hak-akses', navigate: true);
    }

    /**
     * Called after updating a property.
     *
     * @param  string  $property
     * @return void
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'])) {
            $this->resetPage();
        }

        if ($property === 'search') {
            $this->resetSelection();
        }
    }
};
