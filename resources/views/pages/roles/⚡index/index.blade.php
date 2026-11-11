<div>
    {{-- Modal dialogs --}}
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::roles.export />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="peran"
                :records="$this->selectedRecords->pluck('name')->all()"
                wire:key="modal-bulk-destroy-{{ implode('-', $this->selectedRecords->modelKeys()) }}"
            />
        @endteleport
    @endif

    {{-- Listing page --}}
    <x-page :searchable="true">
        {{-- Toolbar actions --}}
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                <div class="d-flex flex-wrap">
                    @can('ekspor peran')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="info"
                            class="mr-2 mb-2"
                        />
                    @endcan
                    @can('hapus peran')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan
                    @can('print peran')
                        <a
                            href="{{ route('peran.pdf') }}"
                            class="btn btn-secondary mr-2 mb-2"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i class="fas fa-print"></i>
                            Cetak
                        </a>
                    @endcan
                    <x-button
                        wire:click="$refresh"
                        icon="fa-sync-alt"
                        label="Muat Ulang"
                        variant="light"
                        class="mb-2"
                        data-toggle="tooltip"
                        title="Muat Ulang"
                    />
                </div>
                @can('tambah peran')
                    <a wire:navigate href="/peran-dan-hak-akses/tambah" class="btn btn-primary mb-2">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Data
                    </a>
                @endcan
            </div>
        </x-slot:toolbar>

        {{-- Data table --}}
        <x-table :targets="['']" :paginator="$this->roles">
            {{-- Table headings --}}
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
                    <th>Nama Peran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            {{-- Table rows --}}
            <x-slot:tbody>
                @forelse ($this->roles as $role)
                    <tr wire:key="role-{{ $role->id }}">
                        {{-- Checkbox --}}
                        <td class="text-center align-middle" style="width: 40px">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $role->id }}"
                                    wire:model.live="selected"
                                    value="{{ $role->id }}"
                                />
                                <label for="checkbox-{{ $role->id }}" class="custom-control-label">&nbsp;</label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $role->name }}</div>

                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <x-badge
                                    :label="'Hak Akses: '.$role->permissions_count"
                                    icon="fa-key"
                                    variant="primary"
                                    class="mr-1"
                                />
                                <x-badge
                                    :label="'Pengguna: '.$role->users_count"
                                    icon="fa-users"
                                    variant="info"
                                    class="mr-1"
                                />
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi peran">
                                @can('ubah peran')
                                    <a
                                        wire:navigate
                                        href="/peran-dan-hak-akses/{{ $role->id }}/ubah"
                                        class="btn btn-sm btn-success"
                                        title="Ubah"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('hapus peran')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $role->id }})"
                                        aria-label="Hapus peran"
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
