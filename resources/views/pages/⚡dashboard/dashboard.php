<?php

declare(strict_types=1);

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

    public function updated(string $property): void
    {
        if (! str_starts_with($property, 'filters.')) {
            return;
        }

        $this->filters->validateOnly(substr($property, strlen('filters.')));
        $this->dispatchChartUpdate();
    }

    public function resetFilters(): void
    {
        $this->filters->reset();
        $this->resetValidation();
        $this->dispatchChartUpdate();
    }

    public function retryDashboard(): void
    {
        $this->resetValidation('dashboard');
        $this->dispatchChartUpdate();
    }

    public function conditionVariant(CommodityCondition $condition): string
    {
        return match ($condition) {
            CommodityCondition::GOOD => 'success',
            CommodityCondition::POOR => 'warning',
            CommodityCondition::HEAVILY_DAMAGED => 'danger',
        };
    }

    private function dispatchChartUpdate(): void
    {
        unset($this->dashboardPageData);

        $pageData = $this->dashboardPageData;

        if ($pageData !== null) {
            $this->dispatch(
                'inventory-dashboard-updated',
                charts: $pageData['dashboard']['charts'],
            );
        }
    }
};
