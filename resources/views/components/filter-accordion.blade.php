<div>
    <div class="accordion pb-3" id="{{ $id }}">
        <div class="accordion-item">
            <div
                wire:ignore.self
                class="accordion-header"
                role="button"
                data-toggle="collapse"
                data-target="#{{ $id }}-body"
                aria-expanded="false"
            >
                <h4>
                    <i class="fas fa-filter mr-2"></i>
                    {{ $title }}
                    <span class="badge badge-primary ml-2">{{ $activeFiltersCount }}</span>
                    <i class="fas fa-chevron-down float-right mt-1"></i>
                </h4>
            </div>
            <div wire:ignore.self class="accordion-body collapse" id="{{ $id }}-body" data-parent="#{{ $id }}">
                <form wire:submit.prevent>{{ $slot }}</form>

                {{-- Filter: Reset Button --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            @if ($activeFiltersCount > 0)
                                <span class="mr-3">
                                    <i class="fas fa-info-circle text-warning mr-1"></i>
                                    <span class="font-weight-bold">{{ $activeFiltersCount }}</span>
                                    filter aktif
                                </span>
                                <button type="button" class="btn btn-warning btn-sm" wire:click="resetFilters">
                                    <i class="fas fa-undo mr-1"></i> Reset Filter
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
