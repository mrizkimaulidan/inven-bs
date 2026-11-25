<div>
    {{-- Modal dialogs --}}
    @if ($activeModal === 'export')
        @teleport('body')
            <livewire:pages::users.export wire:key="modal-export" />
        @endteleport
    @endif

    @if ($activeModal === 'create')
        @teleport('body')
            <livewire:pages::users.create wire:key="modal-create" />
        @endteleport
    @endif

    @if ($activeModal === 'edit')
        @teleport('body')
            <livewire:pages::users.edit :userId="$modalParams['id']" wire:key="modal-edit-{{ $modalParams['id'] }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="pengguna"
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
                    @can('ekspor pengguna')
                        <x-button
                            wire:click="$dispatch('showModal', {modalName: 'export'})"
                            icon="fa-file-export"
                            label="Ekspor"
                            variant="primary"
                            class="mr-2 mb-2"
                        />
                    @endcan
                    @can('hapus pengguna')
                        <x-button
                            wire:click="$dispatch('showBulkDeleteConfirmationModal')"
                            icon="fa-trash-alt"
                            label="Hapus Terpilih"
                            class="mr-2 mb-2"
                            variant="danger"
                            :disabled="empty($selected)"
                        />
                    @endcan
                    @can('print pengguna')
                        <a
                            href="{{ route('pengguna.pdf') }}"
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
                @can('tambah pengguna')
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

        <x-filter-accordion id="filter-accordion" title="Filter Data" :active-filters-count="$this->activeFiltersCount">
            {{-- Filter: Select Inputs --}}
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select name="filters.role" label="Peran" icon="fa-shield-alt" wire:model.live="filters.role">
                        <option value="">Semua Peran</option>
                        @foreach ($this->roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </x-filter-accordion>

        {{-- Data table --}}
        <x-table :targets="[]" :paginator="$this->users">
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
                    <th scope="col">Nama Pengguna</th>
                    <th scope="col">Alamat Email</th>
                    <th scope="col">Ditambahkan Pada</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </x-slot:thead>

            {{-- Table rows --}}
            <x-slot:tbody>
                @forelse ($this->users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        {{-- Checkbox --}}
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox-{{ $user->id }}"
                                    wire:model.live.debounce.200ms="selected"
                                    value="{{ $user->id }}"
                                />
                                <label
                                    for="checkbox-{{ $user->id }}"
                                    class="custom-control-label"
                                    aria-hidden="true"
                                ></label>
                            </div>
                        </td>

                        {{-- Nama & badge peran --}}
                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $user->name }}</div>

                            @if ($user->roles->isNotEmpty())
                                <div class="d-flex align-items-center flex-wrap">
                                    <x-badge
                                        :label="$user->roles->first()->name"
                                        icon="fa-shield-alt"
                                        variant="primary"
                                        class="mb-1"
                                    />
                                </div>
                            @endif
                        </td>

                        {{-- Alamat Email --}}
                        <td class="py-3 align-middle">
                            <span class="font-weight-bold">{{ Str::mask($user->email, '*', 3) }}</span>
                        </td>

                        {{-- Ditambahkan Pada --}}
                        <td class="py-3 align-middle">
                            <span class="text-muted">{{ $user->created_at->translatedFormat('d F Y H:i') }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi pengguna">
                                @can('ubah pengguna')
                                    <x-button
                                        label=""
                                        icon="fa-edit"
                                        variant="success"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'edit', params: {id: {{ $user->id }}}})"
                                        aria-label="Ubah pengguna"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Ubah"
                                    />
                                @endcan
                                @can('hapus pengguna')
                                    <x-button
                                        label=""
                                        icon="fa-trash"
                                        variant="danger"
                                        class="btn-sm"
                                        wire:click="destroy({{ $user->id }})"
                                        wire:confirm="Yakin ingin menghapus pengguna '{{ $user->name }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy"
                                        aria-label="Hapus pengguna"
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
                        <x-empty-state :search="$this->search" colspan="5" />
                    </tr>
                @endforelse
            </x-slot:tbody>
        </x-table>
    </x-page>
</div>
