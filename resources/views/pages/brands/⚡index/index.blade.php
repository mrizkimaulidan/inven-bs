<div>
    {{-- Modal --}}
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::brands.export />
        @endteleport
    @endif

    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::brands.create />
        @endteleport
    @endif

    @if ($activeModal === 'show')
        @teleport('body')
            <livewire:pages::brands.show :brandId="$modalParams['id']" wire:key="modal-show-{{ $modalParams['id'] }}" />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::brands.edit :brandId="$modalParams['id']" wire:key="modal-edit-{{ $modalParams['id'] }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="merek"
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
                        label="Ekspor"
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
        <x-table :targets="['']" :paginator="$this->brands">
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
                    <th>Nama Merek</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($this->brands as $brand)
                    <tr wire:key="brand-{{ $brand->id }}">
                        {{-- Checkbox --}}
                        <td class="text-center align-middle" style="width: 40px">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $brand->id }}"
                                    wire:model.live="selected"
                                    value="{{ $brand->id }}"
                                />
                                <label for="checkbox-{{ $brand->id }}" class="custom-control-label">&nbsp;</label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $brand->name }}</div>

                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <x-badge
                                    :label="$brand->commodities_count"
                                    icon="fa-boxes-alt"
                                    variant="info"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$brand->good_conditions_count"
                                    icon="fa-check-circle"
                                    variant="success"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$brand->poor_conditions_count"
                                    icon="fa-exclamation-circle"
                                    variant="warning"
                                    class="mr-1"
                                />

                                <x-badge
                                    :label="$brand->heavily_damaged_conditions_count"
                                    icon="fa-circle-xmark"
                                    variant="danger"
                                />
                            </div>

                            <div class="table-links">
                                <a
                                    href="#"
                                    wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $brand->id }}}})"
                                    class="btn btn-sm btn-outline-info"
                                    title="Detail"
                                >
                                    <i class="fas fa-search"></i>
                                </a>
                                <a
                                    href="#"
                                    wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $brand->id }}}})"
                                    class="btn btn-sm btn-outline-success"
                                    title="Ubah"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    href="#"
                                    wire:click="destroy({{ $brand->id }})"
                                    class="btn btn-sm btn-outline-danger"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Hapus"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
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
</div>
