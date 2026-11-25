<div class="row">
    <div class="col-12">
        <x-alert />

        <div class="card">
            <div class="card-body">
                {{ $toolbar ?? '' }}

                @if ($searchable)
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <x-select name="{{ $perPageProperty }}" wire:model.live="{{ $perPageProperty }}">
                            @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </x-select>

                        <div class="mt-md-0 mt-2" style="max-width: 300px">
                            <div class="input-group">
                                <input
                                    type="search"
                                    class="form-control"
                                    placeholder="{{ $searchPlaceholder }}"
                                    aria-label="{{ $searchPlaceholder }}"
                                    wire:model.live.debounce.500ms="{{ $searchProperty }}"
                                />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" aria-label="Cari">
                                        <i class="fas fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
</div>
