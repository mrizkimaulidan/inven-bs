<?php

use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithModal;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Provide the users listing, filters, pagination, and record actions.
 */
new #[Title('Halaman Daftar Pengguna')] class extends Component
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
    public function users(): LengthAwarePaginator
    {
        $query = User::query()->with('roles');

        $query->when(filled($this->search), function (Builder $query) {
            $query->search($this->search);
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
        return 'users';
    }

    /**
     * Get the destination after a successful bulk delete.
     *
     * @return ?string
     */
    protected function bulkRedirectPath(): ?string
    {
        return '/pengguna';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return void
     */
    public function destroy(User $user): void
    {
        $user->delete();

        session()->flash('success', 'Data pengguna berhasil dihapus!');
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
