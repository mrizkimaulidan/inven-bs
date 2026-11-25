<?php

use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithFilters;
use App\Livewire\Concerns\WithModal;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

/**
 * Provide the users listing, filters, pagination, and record actions.
 */
new #[Title('Halaman Daftar Pengguna')] class extends Component
{
    use WithBulkDelete, WithFilters, WithModal, WithPagination;

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
     * Initialize the default user filters.
     */
    public function mount(): void
    {
        $this->initializeFilters([
            'role' => '',
        ]);
    }

    /**
     * Get a paginated listing of users with applied search and filters.
     *
     * @return LengthAwarePaginator<int, User>
     */
    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $query = User::query()->with('roles');

        $query->when(filled($this->search), function (Builder $query): void {
            $query->search($this->search);
        });

        $this->applyFilters($query, $this->filterMap());

        return $query->paginate($this->perPage);
    }

    /**
     * Get all available roles for the role filter dropdown.
     *
     * @return Collection<int, Role>
     */
    #[Computed]
    public function roles(): Collection
    {
        return Role::all();
    }

    /**
     * Map each filter key to its corresponding column, scope, or query resolver.
     *
     * @return array<string, string|array<string, mixed>|Closure>
     */
    protected function filterMap(): array
    {
        return [
            'role' => fn (Builder $query, mixed $filterValue): Builder => $query->whereHas(
                'roles',
                fn (Builder $roleQuery): Builder => $roleQuery->whereKey((int) $filterValue)
            ),
        ];
    }

    /**
     * The name of the computed property used by WithBulkDelete.
     */
    protected function bulkPaginatorName(): string
    {
        return 'users';
    }

    /**
     * Get the destination path after a successful bulk delete.
     */
    protected function bulkRedirectPath(): ?string
    {
        return '/pengguna';
    }

    /**
     * Get the permission module name for bulk actions.
     */
    protected function bulkPermissionModule(): string
    {
        return 'pengguna';
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): void
    {
        $this->authorizeModuleAction('hapus', 'pengguna');

        $user->delete();

        session()->flash('success', 'Data pengguna berhasil dihapus!');
    }

    /**
     * Reset pagination and bulk selection when relevant properties change.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'], true)) {
            $this->resetPage();
        }

        if ($property === 'search' || str_starts_with($property, 'filters.')) {
            $this->resetSelection();
        }
    }
};
