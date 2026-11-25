@php
    $brandPaginator = $this->brands;
    $modalId = $modalParams['id'] ?? null;
    $hasModalId = filled($modalId);
    $selectedRecords = $this->selectedRecords;
    $selectedNames = $selectedRecords->pluck('name')->all();
    $selectedKeys = implode('-', $selectedRecords->modelKeys());
@endphp

<div>
    @if ($activeModal === 'import')
        @teleport('body')
            <livewire:pages::brands.import wire:key="modal-import" />
        @endteleport
    @endif

    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::brands.export wire:key="modal-export" />
        @endteleport
    @endif

    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::brands.create wire:key="modal-create" />
        @endteleport
    @endif

    @if ($activeModal === 'show' && $hasModalId)
        @teleport('body')
            <livewire:pages::brands.show :brandId="$modalId" wire:key="modal-show-{{ $modalId }}" />
        @endteleport
    @endif

    @if ($activeModal === 'edit' && $hasModalId)
        @teleport('body')
            <livewire:pages::brands.edit :brandId="$modalId" wire:key="modal-edit-{{ $modalId }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="merek"
                :records="$selectedNames"
                wire:key="modal-bulk-destroy-{{ $selectedKeys !== '' ? $selectedKeys : 'empty' }}"
            />
        @endteleport
    @endif

    <x-page :searchable="true">
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap">
                    @can('impor merek')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'import'})"
                            icon="fa-file-import"
                            label="Impor"
                            variant="success"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('ekspor merek')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
                            class="mr-2 mb-2"
                        />
                    @endcan

                    @can('hapus merek')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan

                    @can('print merek')
                        <a
                            href="{{ route('merek.pdf') }}"
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

                @can('tambah merek')
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

        <x-table :targets="[]" :paginator="$brandPaginator">
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
                    <th scope="col">Nama Merek</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($brandPaginator as $brand)
                    @php
                        $commoditiesCount = (int) ($brand->commodities_count ?? 0);
                        $goodCount = (int) ($brand->good_conditions_count ?? 0);
                        $poorCount = (int) ($brand->poor_conditions_count ?? 0);
                        $damagedCount = (int) ($brand->heavily_damaged_conditions_count ?? 0);
                    @endphp

                    <tr wire:key="brand-{{ $brand->id }}">
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $brand->id }}"
                                    wire:model.live.debounce.200ms="selected"
                                    value="{{ $brand->id }}"
                                />
                                <label
                                    for="checkbox-{{ $brand->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $brand->name ?? '-' }}</div>

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

                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi merek">
                                @can('detail merek')
                                    <x-button
                                        label=""
                                        icon="fa-search"
                                        variant="info"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $brand->id }}}})"
                                        aria-label="Detail merek"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Detail"
                                    />
                                @endcan

                                @can('ubah merek')
                                    <x-button
                                        label=""
                                        icon="fa-edit"
                                        variant="success"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $brand->id }}}})"
                                        aria-label="Ubah merek"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    />
                                @endcan

                                @can('hapus merek')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $brand->id }})"
                                        wire:confirm="Yakin ingin menghapus merek '{{ $brand->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy({{ $brand->id }})"
                                        aria-label="Hapus merek"
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
                        <x-empty-state :search="$this->search" colspan="3" />
                    </tr>
                @endforelse
            </x-slot:tbody>
        </x-table>
    </x-page>
</div>
