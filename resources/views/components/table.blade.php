@php
    $targets = $resolvedTargets();
@endphp

<div>
    <div wire:loading.block wire:target="{{ $targets }}" class="py-5 text-center">
        <div class="spinner-border text-primary mb-3" role="status">
            <span class="sr-only">Memuat...</span>
        </div>
        <p class="text-muted mb-0">Sedang memperbarui data...</p>
    </div>

    <div wire:loading.remove wire:target="{{ $targets }}">
        <div class="table-responsive">
            <table class="table-striped table-hover mb-0 table">
                <thead class="thead-light">
                    {{ $thead ?? '' }}
                </thead>
                <tbody>
                    {{ $tbody ?? '' }}
                </tbody>
            </table>
        </div>

        @if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            <x-pagination :paginator="$paginator" />
        @endif
    </div>
</div>
