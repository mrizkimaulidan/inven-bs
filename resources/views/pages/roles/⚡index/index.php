<?php

use App\WithBulkDelete;
use App\WithModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

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
     */
    protected function bulkPaginatorName(): string
    {
        return 'roles';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): void
    {
        $role->delete();

        $this->redirect('/peran-dan-hak-akses', navigate: true);
    }

    /**
     * Called after updating a property.
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
