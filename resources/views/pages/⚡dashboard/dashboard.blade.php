@php($dashboardPageData = $this->dashboardPageData)

<div>
    {{-- ===== START: Dashboard Header ===== --}}
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
    {{-- ===== END: Dashboard Header ===== --}}

    @if ($dashboardPageData === null)
        {{-- ===== START: Dashboard Error State ===== --}}
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
                    <button type="button" class="btn btn-danger btn-sm mt-md-0 mt-2" wire:click="retryDashboard">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
        {{-- ===== END: Dashboard Error State ===== --}}
    @else
        @include('pages.⚡dashboard.partials.filters', ['pageData' => $dashboardPageData])
        @include('pages.⚡dashboard.partials.metrics', ['summary' => $dashboardPageData['dashboard']['summary']])
        @include('pages.⚡dashboard.partials.charts', ['charts' => $dashboardPageData['dashboard']['charts']])
        @include('pages.⚡dashboard.partials.recent-items', ['items' => $dashboardPageData['dashboard']['recentItems']])

        <script src="{{ asset('js/dashboard-charts.js') }}" data-navigate-once></script>
        @script
            <script>
                window.InventoryDashboardCharts.mount($wire, @js($dashboardPageData['dashboard']['charts']));
            </script>
        @endscript
    @endif
</div>
