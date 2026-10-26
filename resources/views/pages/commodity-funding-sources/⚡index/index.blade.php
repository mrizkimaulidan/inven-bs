<div>
    {{-- Modal --}}
    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::commodity-funding-sources.create />
        @endteleport
    @endif

    @if ($activeModal === 'show')
        @teleport('body')
            <livewire:pages::commodity-funding-sources.show
                :commodityFundingSourceId="$modalParams['id']"
                wire:key="modal-show-{{ $modalParams['id'] }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::commodity-funding-sources.edit
                :commodityFundingSourceId="$modalParams['id']"
                wire:key="modal-edit-{{ $modalParams['id'] }}"
            />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="perolehan"
                :records="$this->selectedRecords->pluck('name')->all()"
                wire:key="modal-bulk-destroy-{{ implode('-', $this->selectedRecords->modelKeys()) }}"
            />
        @endteleport
    @endif

    {{-- Main Card --}}
    <x-page :searchable="true">
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                <div class="d-flex flex-wrap">
                    <x-button icon="fa-file-import" label="Import" variant="success" class="mr-2 mb-2" />
                    <x-button
                        wire:click="$dispatch('showModal', {modalName: 'export'})"
                        icon="fa-file-export"
                        label="Export"
                        variant="info"
                        class="mr-2 mb-2"
                    />
                    <x-button
                        wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                        icon="fa-trash-alt"
                        label="Hapus Terpilih"
                        class="mr-2 mb-2"
                        variant="danger"
                        :disabled="empty($selected)"
                    />
                    <x-button icon="fa-print" label="Print" variant="secondary" class="mr-2 mb-2" />
                    <x-button
                        wire:click="$refresh"
                        icon="fa-sync-alt"
                        label="Refresh"
                        variant="light"
                        class="mb-2"
                        data-toggle="tooltip"
                        title="Refresh"
                    />
                </div>
                <x-button
                    wire:click="$dispatch('showModal', {modalName: 'create'})"
                    icon="fa-plus-circle"
                    label="Tambah Data"
                    variant="primary"
                    class="mb-2"
                />
            </div>
        </x-slot:toolbar>

        {{-- Table --}}
        <x-table :targets="['']" :paginator="$this->commodityFundingSources">
            <x-slot:thead>
                <tr>
                    <th class="text-center" style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="checkbox-all"
                                wire:model.live="selectAll"
                            />
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                        </div>
                    </th>
                    <th>Nama Perolehan</th>
                    <th>Deskripsi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($this->commodityFundingSources as $commodityFundingSource)
                    <tr wire:key="commodity-funding-source-{{ $commodityFundingSource->id }}">
                        {{-- Checkbox --}}
                        <td class="text-center align-middle" style="width: 40px">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $commodityFundingSource->id }}"
                                    wire:model.live="selected"
                                    value="{{ $commodityFundingSource->id }}"
                                />
                                <label for="checkbox-{{ $commodityFundingSource->id }}" class="custom-control-label"
                                    >&nbsp;</label>
                            </div>
                        </td>

                        {{-- Ruang --}}
                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $commodityFundingSource->name }}</div>

                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <x-badge
                                    :label="$commodityFundingSource->commodities_count"
                                    icon="fa-boxes-alt"
                                    variant="info"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$commodityFundingSource->good_conditions_count"
                                    icon="fa-check-circle"
                                    variant="success"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$commodityFundingSource->poor_conditions_count"
                                    icon="fa-exclamation-circle"
                                    variant="warning"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$commodityFundingSource->heavily_damaged_conditions_count"
                                    icon="fa-circle-xmark"
                                    variant="danger"
                                />
                            </div>

                            <div class="table-links">
                                <a
                                    href="#"
                                    wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $commodityFundingSource->id }}}})"
                                    class="btn btn-sm btn-outline-info"
                                    title="Detail"
                                >
                                    <i class="fas fa-search"></i>
                                </a>
                                <a
                                    href="#"
                                    wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $commodityFundingSource->id }}}})"
                                    class="btn btn-sm btn-outline-success"
                                    title="Ubah"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    href="#"
                                    wire:click="destroy({{ $commodityFundingSource->id }})"
                                    class="btn btn-sm btn-outline-danger"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Hapus"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>

                        {{-- Deskripsi --}}
                        <td class="py-3 align-middle">
                            <span class="text-muted">{{ $commodityFundingSource->description ?: '—' }}</span>
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
