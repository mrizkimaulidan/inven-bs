@php
    $rolePaginator = $this->roles;
    $selectedRecords = $this->selectedRecords;
    $selectedNames = $selectedRecords->pluck('name')->all();
    $selectedKeys = implode('-', $selectedRecords->modelKeys());
@endphp

<div>
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::roles.export wire:key="modal-export" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="peran"
                :records="$selectedNames"
                wire:key="modal-bulk-destroy-{{ $selectedKeys !== '' ? $selectedKeys : 'empty' }}"
            />
        @endteleport
    @endif

    <x-page :searchable="true">
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap">
                    @can('ekspor peran')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
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
                            href="{{ route('peran-dan-hak-akses.pdf') }}"
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

                @can('tambah peran')
                    <a
                        wire:navigate
                        href="{{ route('peran-dan-hak-akses.create') }}"
                        class="btn btn-primary mb-2 ml-auto"
                    >
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        Tambah Data
                    </a>
                @endcan
            </div>
        </x-slot:toolbar>

        <x-table :targets="[]" :paginator="$rolePaginator">
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
                    <th scope="col">Nama Peran</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($rolePaginator as $role)
                    @php
                        $permissionsCount = (int) ($role->permissions_count ?? 0);
                        $usersCount = (int) ($role->users_count ?? 0);
                    @endphp

                    <tr wire:key="role-{{ $role->id }}">
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $role->id }}"
                                    wire:model.live.debounce.200ms="selected"
                                    value="{{ $role->id }}"
                                />
                                <label
                                    for="checkbox-{{ $role->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $role->name ?? '-' }}</div>

                            <div class="d-flex align-items-center flex-wrap">
                                <x-badge
                                    :label="'Hak Akses: '.$permissionsCount"
                                    icon="fa-key"
                                    variant="primary"
                                    class="mr-1 mb-1"
                                />
                                <x-badge
                                    :label="'Pengguna: '.$usersCount"
                                    icon="fa-users"
                                    variant="info"
                                    class="mb-1"
                                />
                            </div>
                        </td>

                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi peran">
                                @can('ubah peran')
                                    <a
                                        wire:navigate
                                        href="{{ route('peran-dan-hak-akses.edit', $role) }}"
                                        class="btn btn-sm btn-success"
                                        aria-label="Ubah peran"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    >
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                @endcan

                                @can('hapus peran')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $role->id }})"
                                        wire:confirm="Yakin ingin menghapus peran '{{ $role->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy({{ $role->id }})"
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
