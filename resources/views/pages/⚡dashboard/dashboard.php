<?php

use App\Enums\CommodityCondition;
use App\Livewire\Forms\DashboardFilterForm;
use App\Services\InventoryDashboardService;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Beranda')] class extends Component
{
    public DashboardFilterForm $filters;

    /**
     * Build dashboard filter options and summary payload.
     *
     * @return array<string, mixed>|null
     */
    #[Computed]
    public function dashboardPageData(): ?array
    {
        $this->resetValidation('dashboard');

        try {
            $service = app(InventoryDashboardService::class);

            return [
                'filterOptions' => $service->getFilterOptions(),
                'dashboard' => $service->getDashboardData($this->filters->values()),
            ];
        } catch (QueryException $exception) {
            report($exception);
            $this->addError('dashboard', 'Gagal memuat data inventaris. Silakan coba lagi.');

            return null;
        }
    }

    /**
     * Validate updated filter fields and refresh dashboard chart data.
     */
    public function updated(string $property): void
    {
        if (! str_starts_with($property, 'filters.')) {
            return;
        }

        $field = substr($property, strlen('filters.'));
        if ($field !== '') {
            $this->filters->validateOnly($field);
        }

        $this->dispatchChartUpdate();
    }

    /**
     * Reset all active filters and clear validation errors.
     */
    public function resetFilters(): void
    {
        $this->filters->reset();
        $this->resetValidation();
        $this->dispatchChartUpdate();
    }

    /**
     * Retry loading dashboard data after a query failure.
     */
    public function retryDashboard(): void
    {
        $this->resetValidation('dashboard');
        $this->dispatchChartUpdate();
    }

    /**
     * Map commodity condition to a Bootstrap badge variant.
     */
    public function conditionVariant(CommodityCondition $condition): string
    {
        return match ($condition) {
            CommodityCondition::GOOD => 'success',
            CommodityCondition::POOR => 'warning',
            CommodityCondition::HEAVILY_DAMAGED => 'danger',
        };
    }

    /**
     * Refresh computed dashboard data and dispatch updated chart payload.
     */
    private function dispatchChartUpdate(): void
    {
        unset($this->dashboardPageData);

        $pageData = $this->dashboardPageData;
        $charts = is_array($pageData['dashboard'] ?? null)
            ? ($pageData['dashboard']['charts'] ?? [])
            : [];

        if ($pageData !== null) {
            $this->dispatch('inventory-dashboard-updated', charts: $charts);
        }
    }
};
