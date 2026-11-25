@php
    $locationPaginator = $this->commodityLocations;
    $modalId = $modalParams['id'] ?? null;
    $hasModalId = filled($modalId);
    $selectedRecords = $this->selectedRecords;
    $selectedNames = $selectedRecords->pluck('name')->all();
    $selectedKeys = implode('-', $selectedRecords->modelKeys());
@endphp

<div>
    @if ($activeModal === 'import')
        @teleport('body')
            <livewire:pages::commodity-locations.import wire:key="modal-import" />
        @endteleport
    @endif

    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::commodity-locations.export wire:key="modal-export" />
        @endteleport
    @endif

    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::commodity-locations.create wire:key="modal-create" />
        @endteleport
    @endif

    @if ($activeModal === 'show' && $hasModalId)
        @teleport('body')
            <livewire:pages::commodity-locations.show
                :commodityLocationId="$modalId"
                wire:key="modal-show-{{ $modalId }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'edit' && $hasModalId)
        @teleport('body')
            <livewire:pages::commodity-locations.edit
                :commodityLocationId="$modalId"
                wire:key="modal-edit-{{ $modalId }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="ruangan"
                :records="$selectedNames"
                wire:key="modal-bulk-destroy-{{ $selectedKeys !== '' ? $selectedKeys : 'empty' }}"
            />
        @endteleport
    @endif

    <x-page :searchable="true">
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap">
                    @can('impor ruangan')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'import'})"
                            icon="fa-file-import"
                            label="Impor"
                            variant="success"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('ekspor ruangan')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('hapus ruangan')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan

                    @can('print ruangan')
                        <a
                            href="{{ route('ruangan.pdf') }}"
                            class="btn btn-secondary mr-2 mb-2"
                            title="Cetak"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i class="fas fa-print" aria-hidden="true"></i>
                            Cetak
                        </a>
                    @endcan

                    <x-button
                        wire:click="$refresh"
                        icon="fa-sync-alt"
                        label="Muat Ulang"
                        variant="light"
                        class="mb-2"
                        wire:loading.attr="disabled"
                        wire:target="$refresh"
                        data-toggle="tooltip"
                        title="Muat Ulang"
                    />
                </div>

                @can('tambah ruangan')
                    <x-button
                        wire:click="$dispatch('showModal', {modalName: 'create'})"
                        icon="fa-plus-circle"
                        label="Tambah Data"
                        variant="primary"
                        class="mb-2 ml-auto"
                    />
                @endcan
            </div>
        </x-slot:toolbar>

        <x-table :targets="[]" :paginator="$locationPaginator">
            <x-slot:thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="checkbox-all"
                                wire:model.live.debounce.200ms="selectAll"
                            />
                            <label for="checkbox-all" class="custom-control-label" aria-hidden="true"></label>
                        </div>
                    </th>
                    <th scope="col">Nama Ruangan</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($locationPaginator as $location)
                    @php
                        $commoditiesCount = (int) ($location->commodities_count ?? 0);
                        $goodCount = (int) ($location->good_conditions_count ?? 0);
                        $poorCount = (int) ($location->poor_conditions_count ?? 0);
                        $damagedCount = (int) ($location->heavily_damaged_conditions_count ?? 0);
                        $description = filled($location->description) ? $location->description : '-';
                    @endphp

                    <tr wire:key="location-{{ $location->id }}">
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $location->id }}"
                                    wire:model.live.debounce.200ms="selected"
                                    value="{{ $location->id }}"
                                />
                                <label
                                    for="checkbox-{{ $location->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $location->name ?? '-' }}</div>

                            <div class="d-flex align-items-center flex-wrap">
                                <x-badge
                                    :label="$commoditiesCount"
                                    icon="fa-boxes-alt"
                                    variant="primary"
                                    class="mr-1 mb-1"
                                />

                                <x-badge
                                    :label="$goodCount"
                                    icon="fa-check-circle"
                                    variant="success"
                                    class="text-dark mr-1 mb-1"
                                />

                                <x-badge
                                    :label="$poorCount"
                                    icon="fa-exclamation-circle"
                                    variant="warning"
                                    class="text-dark mr-1 mb-1"
                                />

                                <x-badge :label="$damagedCount" icon="fa-circle-xmark" variant="danger" class="mb-1" />
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <span class="text-muted">{{ $description }}</span>
                        </td>

                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi ruangan">
                                @can('detail ruangan')
                                    <x-button
                                        label=""
                                        icon="fa-search"
                                        variant="info"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $location->id }}}})"
                                        aria-label="Detail ruangan"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Detail"
                                    />
                                @endcan

                                @can('ubah ruangan')
                                    <x-button
                                        label=""
                                        icon="fa-edit"
                                        variant="success"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $location->id }}}})"
                                        aria-label="Ubah ruangan"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    />
                                @endcan

                                @can('hapus ruangan')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $location->id }})"
                                        wire:confirm="Yakin ingin menghapus ruangan '{{ $location->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy({{ $location->id }})"
                                        aria-label="Hapus ruangan"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Hapus"
                                    />
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <x-empty-state :search="$this->search" colspan="4" />
                    </tr>
                @endforelse
            </x-slot:tbody>
        </x-table>
    </x-page>
</div>
