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
        $perPage = max(1, $this->perPage);
        $keyword = trim($this->search);

        $query = User::query()->with('roles');

        $query->when($keyword !== '', static function (Builder $query) use ($keyword): void {
            $query->search($keyword);
        });

        $this->applyFilters($query, $this->filterMap());

        return $query->paginate($perPage);
    }

    /**
     * Get all available roles for the role filter dropdown.
     *
     * @return Collection<int, Role>
     */
    #[Computed]
    public function roles(): Collection
    {
        return Role::query()->orderBy('name')->get();
    }

    /**
     * Map each filter key to its corresponding column, scope, or query resolver.
     *
     * @return array<string, string|array<string, mixed>|Closure>
     */
    protected function filterMap(): array
    {
        return [
            'role' => static function (Builder $query, mixed $filterValue): Builder {
                $roleId = (int) $filterValue;

                if ($roleId <= 0) {
                    return $query;
                }

                return $query->whereHas(
                    'roles',
                    static fn (Builder $roleQuery): Builder => $roleQuery->whereKey($roleId),
                );
            },
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
        return route('pengguna.index');
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

        $this->redirect(route('pengguna.index'), navigate: true);
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
