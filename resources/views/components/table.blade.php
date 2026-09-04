<div>
    {{-- Loading overlay --}}
    <div wire:loading.block wire:target="{{ $resolvedTargets }}" class="py-5 text-center">
        <div class="spinner-border text-primary mb-3" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="text-muted mb-0">Sedang memperbarui data...</p>
    </div>

    {{-- Table --}}
    <div wire:loading.remove wire:target="{{ $resolvedTargets }}">
        <div class="table-responsive">
            <table class="table-striped table-hover mb-0 table">
                <thead class="thead-light">
                    {{ $thead }}
                </thead>
                <tbody>
                    {{ $tbody }}
                </tbody>
            </table>
        </div>
    </div>

    @if ($paginator)
        {{-- Pagination --}}
        <x-pagination :paginator="$paginator" />
    @endif
</div>
