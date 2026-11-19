<div>
    {{-- Modal dialogs --}}
    @if ($activeModal === 'import')
        @teleport('body')
            <livewire:pages::materials.import wire:key="modal-import" />
        @endteleport
    @endif

    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::materials.export wire:key="modal-export" />
        @endteleport
    @endif

    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::materials.create wire:key="modal-create" />
        @endteleport
    @endif

    @if ($activeModal === 'show')
        @teleport('body')
            <livewire:pages::materials.show
                :materialId="$modalParams['id']"
                wire:key="modal-show-{{ $modalParams['id'] }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::materials.edit
                :materialId="$modalParams['id']"
                wire:key="modal-edit-{{ $modalParams['id'] }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="bahan"
                :records="$this->selectedRecords->pluck('name')->all()"
                wire:key="modal-bulk-destroy-{{ implode('-', $this->selectedRecords->modelKeys()) }}"
            />
        @endteleport
    @endif

    {{-- Listing page --}}
    <x-page :searchable="true">
        {{-- Toolbar actions --}}
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap">
                    @can('impor bahan')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'import'})"
                            icon="fa-file-import"
                            label="Impor"
                            variant="success"
                            class="mr-2 mb-2"
                        />
                    @endcan
                    @can('ekspor bahan')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
                            class="mr-2 mb-2"
                        />
                    @endcan
                    @can('hapus bahan')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan
                    @can('print bahan')
                        <a
                            href="{{ route('bahan.pdf') }}"
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
                @can('tambah bahan')
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

        {{-- Data table --}}
        <x-table :targets="[]" :paginator="$this->materials">
            {{-- Table headings --}}
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
                    <th scope="col">Nama Bahan</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            {{-- Table rows --}}
            <x-slot:tbody>
                @forelse ($this->materials as $material)
                    <tr wire:key="material-{{ $material->id }}">
                        {{-- Checkbox --}}
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $material->id }}"
                                    wire:model.live.debounce.200ms="selected"
                                    value="{{ $material->id }}"
                                />
                                <label
                                    for="checkbox-{{ $material->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        {{-- Nama & badge kondisi --}}
                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $material->name }}</div>

                            <div class="d-flex align-items-center flex-wrap">
                                <x-badge
                                    :label="$material->commodities_count"
                                    icon="fa-boxes-alt"
                                    variant="primary"
                                    class="mr-1 mb-1"
                                />

                                <x-badge
                                    :label="$material->good_conditions_count"
                                    icon="fa-check-circle"
                                    variant="success"
                                    class="text-dark mr-1 mb-1"
                                />

                                <x-badge
                                    :label="$material->poor_conditions_count"
                                    icon="fa-exclamation-circle"
                                    variant="warning"
                                    class="text-dark mr-1 mb-1"
                                />

                                <x-badge
                                    :label="$material->heavily_damaged_conditions_count"
                                    icon="fa-circle-xmark"
                                    variant="danger"
                                    class="mb-1"
                                />
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi bahan">
                                @can('detail bahan')
                                    <x-button
                                        label=""
                                        icon="fa-search"
                                        variant="info"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $material->id }}}})"
                                        aria-label="Detail bahan"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Detail"
                                    />
                                @endcan
                                @can('ubah bahan')
                                    <x-button
                                        label=""
                                        icon="fa-edit"
                                        variant="success"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $material->id }}}})"
                                        aria-label="Ubah bahan"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    />
                                @endcan
                                @can('hapus bahan')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $material->id }})"
                                        wire:confirm="Yakin ingin menghapus bahan '{{ $material->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy"
                                        aria-label="Hapus bahan"
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
