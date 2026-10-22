<div>
    {{-- Modal --}}
    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::brands.create />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::brands.edit :brandId="$modalParams['id']" wire:key="modal-edit-{{ $modalParams['id'] }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:pages::brands.bulk-destroy
                :ids="$modalParams['ids']"
                wire:key="modal-bulk-destroy-{{ implode('-', $modalParams['ids']) }}"
            />
        @endteleport
    @endif

    {{-- Main Card --}}
    <x-page :searchable="true">
        <x-slot:toolbar>
            {{-- Toolbar: Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                <div class="d-flex flex-wrap">
                    <x-button icon="fa-file-import" label="Import" class="btn-success mr-2 mb-2" />
                    <x-button
                        wire:click="$dispatch('showModal', {modalName: 'export'})"
                        icon="fa-file-export"
                        label="Export"
                        class="btn-info mr-2 mb-2"
                    />
                    <x-button
                        wire:click="$dispatch('showModal', {modalName: 'bulk-destroy', params: {ids: {{ json_encode($selected) }}}})"
                        icon="fa-trash-alt"
                        label="Hapus Terpilih"
                        class="btn-danger mr-2 mb-2"
                        :disabled="empty($selected)"
                    />
                    <x-button icon="fa-print" label="Print" class="btn-secondary mr-2 mb-2" />
                    <x-button
                        wire:click="$refresh"
                        icon="fa-sync-alt"
                        label="Refresh"
                        class="btn-light mb-2"
                        data-toggle="tooltip"
                        title="Refresh"
                    />
                </div>
                <a wire:navigate href="/peran-dan-hak-akses/tambah" class="btn btn-primary mb-2">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Data
                </a>
            </div>
        </x-slot:toolbar>

        {{-- Table --}}
        <x-table :targets="['']" :paginator="$this->roles">
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
                </tr>
            </x-slot:thead>

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
                                    class="badge-primary mr-1"
                                />
                                <x-badge
                                    :label="'Pengguna: '.$role->users_count"
                                    icon="fa-users"
                                    class="badge-info mr-1"
                                />
                            </div>

                            <div class="table-links">
                                <a
                                    wire:navigate
                                    href="/peran-dan-hak-akses/{{ $role->id }}/ubah"
                                    class="btn btn-sm btn-outline-success"
                                    title="Ubah"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    href="#"
                                    wire:click="destroy({{ $role->id }})"
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
