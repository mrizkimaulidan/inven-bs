@php
    $filterCount = max(0, (int) $activeFiltersCount);
@endphp

<div x-data="{ expanded: false }">
    <div class="accordion pb-3" id="{{ $id }}">
        <div class="accordion-item rounded border">
            <a
                class="accordion-header card-header d-flex align-items-center text-decoration-none text-dark bg-white p-3"
                id="{{ $id }}-header"
                href="#{{ $id }}-body"
                role="button"
                @click.prevent="expanded = ! expanded"
                :aria-expanded="expanded.toString()"
                aria-controls="{{ $id }}-body"
            >
                <i class="fas fa-filter text-primary mr-2" aria-hidden="true"></i>
                <h4 class="font-weight-bold mb-0 flex-grow-1" style="font-size: 1.1rem">{{ $title }}</h4>
                @if ($filterCount > 0)
                    <span class="badge badge-primary badge-pill mr-2">{{ $filterCount }}</span>
                @endif
                <i class="fas fa-chevron-down text-muted" :class="{ 'fa-rotate-180': expanded }" aria-hidden="true"></i>
            </a>

            <div
                class="accordion-body"
                id="{{ $id }}-body"
                x-show="expanded"
                x-cloak
                aria-labelledby="{{ $id }}-header"
            >
                <div class="card-body pt-3">
                    <form wire:submit.prevent>
                        {{ $slot }}

                        @if ($filterCount > 0)
                            <hr class="my-3" />
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <span class="text-muted small mb-sm-0 mb-2">
                                    <i class="fas fa-info-circle text-warning mr-1" aria-hidden="true"></i>
                                    <strong>{{ $filterCount }}</strong> filter aktif
                                </span>
                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm"
                                    wire:click="resetFilters"
                                    wire:loading.attr="disabled"
                                    wire:target="resetFilters"
                                >
                                    <i class="fas fa-undo mr-1" aria-hidden="true"></i>
                                    <span wire:loading.remove wire:target="resetFilters">Atur Ulang Filter</span>
                                    <span wire:loading wire:target="resetFilters">
                                        <span
                                            class="spinner-border spinner-border-sm mr-1"
                                            role="status"
                                            aria-hidden="true"
                                        ></span>
                                        Mereset...
                                    </span>
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
