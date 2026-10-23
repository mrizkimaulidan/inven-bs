<div>
    <div class="row">
        <div class="col-12">
            {{-- Notifications --}}
            <x-alert />

            <div class="card">
                <div class="card-body">
                    {{-- Toolbar --}}
                    {{ $toolbar }}

                    {{-- Controls --}}
                    @if ($searchable)
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <x-select name="perPage" wire:model.live="perPage">
                                @foreach ($perPageOptions as $perPage)
                                    <option value="{{ $perPage }}">{{ $perPage }}</option>
                                @endforeach
                            </x-select>

                            <form style="max-width: 300px" class="mt-md-0 mt-2" wire:submit.prevent>
                                <div class="input-group">
                                    <input
                                        type="search"
                                        class="form-control"
                                        placeholder="Cari data"
                                        wire:model.live.debounce.500ms="search"
                                    />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Content --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
