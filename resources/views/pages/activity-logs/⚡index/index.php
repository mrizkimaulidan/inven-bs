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
     */
    #[Computed]
    public function activityLogs(): LengthAwarePaginator
    {
        return AuditLog::query()
            ->with('causer')
            ->when(filled($this->search), function (Builder $query) {
                $query->search($this->search);
            })
            ->latest()
            ->paginate($this->perPage);
    }

    protected function bulkPermissionModule(): string
    {
        return 'log aktivitas';
    }

    /**
     * Called after updating a property.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'perPage'])) {
            $this->resetPage();
        }
    }
};
