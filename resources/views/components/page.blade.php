<div class="row">
    <div class="col-12">
        {{-- Notifications --}}
        <x-alert />

        <div class="card">
            <div class="card-body">
                {{-- Toolbar (optional named slot). --}}
                {{ $toolbar ?? '' }}

                {{-- Controls --}}
                @if ($searchable)
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        {{-- Per-page selector. --}}
                        <x-select name="{{ $perPageProperty }}" wire:model.live="{{ $perPageProperty }}">
                            @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-select>

                        {{-- Search input. --}}
                        <div class="mt-md-0 mt-2" style="max-width: 300px">
                            <div class="input-group">
                                <input
                                    type="search"
                                    class="form-control"
                                    placeholder="{{ $searchPlaceholder }}"
                                    wire:model.live.debounce.500ms="{{ $searchProperty }}"
                                />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Content --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
