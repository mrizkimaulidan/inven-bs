<div>
    {{-- Modals --}}
    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::users.create />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::users.edit :userId="$modalParams['id']" wire:key="modal-edit-{{ $modalParams['id'] }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:pages::users.bulk-destroy
                :ids="$modalParams['ids']"
                wire:key="modal-bulk-destroy-{{ implode('-', $modalParams['ids']) }}"
            />
        @endteleport
    @endif

    {{-- Page --}}
    <x-page :searchable="true">
        {{-- Toolbar --}}
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
                        wire:click="$dispatch('showModal', {modalName: 'bulk-destroy', params: {ids: {{ json_encode($selected) }}}})"
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
        <x-table :paginator="$this->users">
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
                    <th>Nama Pengguna</th>
                    <th>Alamat Email</th>
                    <th>Ditambahkan Pada</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($this->users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="text-center align-middle" style="width: 40px">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $user->id }}"
                                    wire:model.live="selected"
                                    value="{{ $user->id }}"
                                />
                                <label for="checkbox-{{ $user->id }}" class="custom-control-label">&nbsp;</label>
                            </div>
                        </td>
                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $user->name }}</div>
                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <x-badge
                                    :label="$user->roles->first()->name"
                                    icon="fa-shield-alt"
                                    variant="primary"
                                    class="mr-1"
                                />
                            </div>
                            <div class="table-links">
                                <a
                                    href="#"
                                    wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $user->id }}}})"
                                    class="btn btn-sm btn-outline-success"
                                    title="Ubah"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    wire:click="destroy({{ $user->id }})"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Hapus"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <td><div class="font-weight-bold">{{ Str::mask($user->email, '*', 3) }}</div></td>
                        <td>
                            <div class="font-weight-bold">{{ $user->created_at->translatedFormat('d F Y H:i') }}</div>
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
