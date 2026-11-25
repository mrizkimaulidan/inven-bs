@php
    $dashboardPageData = is_array($this->dashboardPageData ?? null) ? $this->dashboardPageData : null;
    $dashboardData = is_array($dashboardPageData['dashboard'] ?? null) ? $dashboardPageData['dashboard'] : [];
    $summary = is_array($dashboardData['summary'] ?? null) ? $dashboardData['summary'] : [];
    $charts = is_array($dashboardData['charts'] ?? null) ? $dashboardData['charts'] : [];
    $recentItems = $dashboardData['recentItems'] ?? [];
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div class="mb-md-0 mb-2">
                        <h2 class="h4 mb-1">Ringkasan Inventaris</h2>
                        <p class="text-muted mb-0">Pantau jumlah, kondisi, dan penempatan barang inventaris.</p>
                    </div>
                    <span class="badge badge-light">Data langsung</span>
                </div>
            </div>
        </div>
    </div>

    @if ($dashboardPageData === null)
        <div class="row">
            <div class="col-12">
                <div
                    class="alert alert-danger d-flex justify-content-between align-items-center flex-wrap"
                    role="alert"
                >
                    <span>
                        <i class="fas fa-exclamation-circle mr-2" aria-hidden="true"></i>
                        Gagal memuat data inventaris. Silakan coba lagi.
                    </span>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm mt-md-0 mt-2"
                        wire:click="retryDashboard"
                        wire:loading.attr="disabled"
                        wire:target="retryDashboard"
                    >
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    @else
        @include('pages.⚡dashboard.partials.filters', ['pageData' => $dashboardPageData])
        @include('pages.⚡dashboard.partials.metrics', ['summary' => $summary])
        @include('pages.⚡dashboard.partials.charts', ['charts' => $charts])
        @include('pages.⚡dashboard.partials.recent-items', ['items' => $recentItems])

        <script src="{{ asset('js/dashboard-charts.js') }}" data-navigate-once></script>

        @script
            <script>
                if (window.InventoryDashboardCharts && typeof window.InventoryDashboardCharts.mount === 'function') {
                    window.InventoryDashboardCharts.mount($wire, @js($charts));
                }
            </script>
        @endscript
    @endif
</div>
