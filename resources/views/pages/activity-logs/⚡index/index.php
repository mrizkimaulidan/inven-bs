<?php

use App\Livewire\Concerns\WithBulkDelete;
use App\Livewire\Concerns\WithFilters;
use App\Livewire\Concerns\WithModal;
use App\Models\AuditLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Halaman Daftar Log Aktivitas')] class extends Component
{
    use WithBulkDelete, WithFilters, WithModal, WithPagination;

    /**
     * The number of items to display per page.
     */
    #[Url(as: 'per_page')]
    public int $perPage = 10;

    /**
     * The search query string.
     */
    #[Url]
    public string $search = '';

    /**
     * Get a listing of the resource with pagination.
     *
     * @return LengthAwarePaginator<int, AuditLog>
     */
    #[Computed]
    public function activityLogs(): LengthAwarePaginator
    {
        $perPage = max(1, $this->perPage);
        $keyword = trim($this->search);

        return AuditLog::query()
            ->with('causer')
            ->when($keyword !== '', static function (Builder $query) use ($keyword): void {
                $query->search($keyword);
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get the permission module name used by bulk delete actions.
     */
    protected function bulkPermissionModule(): string
    {
        return 'log aktivitas';
    }

    /**
     * Reset pagination when filter or page-size properties change.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'], true)) {
            $this->resetPage();
        }
    }
};
