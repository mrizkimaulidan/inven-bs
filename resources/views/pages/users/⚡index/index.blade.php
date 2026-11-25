@php
    $userPaginator = $this->users;
    $roleOptions = $this->roles ?? collect();
    $activeFiltersCount = (int) ($this->activeFiltersCount ?? 0);
    $modalId = $modalParams['id'] ?? null;
    $hasModalId = filled($modalId);
    $selectedRecords = $this->selectedRecords;
    $selectedNames = $selectedRecords->pluck('name')->all();
    $selectedKeys = implode('-', $selectedRecords->modelKeys());
@endphp

<div>
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

    @if ($activeModal === 'edit' && $hasModalId)
        @teleport('body')
            <livewire:pages::users.edit :userId="$modalId" wire:key="modal-edit-{{ $modalId }}" />
        @endteleport
    @endif

    @if ($activeModal === 'bulk-destroy')
        @teleport('body')
            <livewire:bulk-destroy
                resource-label="pengguna"
                :records="$selectedNames"
                wire:key="modal-bulk-destroy-{{ $selectedKeys !== '' ? $selectedKeys : 'empty' }}"
            />
        @endteleport
    @endif

    <x-page :searchable="true">
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

        <x-filter-accordion id="filter-accordion" title="Filter Data" :active-filters-count="$activeFiltersCount">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <x-select name="filters.role" label="Peran" icon="fa-shield-alt" wire:model.live="filters.role">
                        <option value="">Semua Peran</option>
                        @foreach ($roleOptions as $role)
                            <option value="{{ $role->id }}" wire:key="filter-role-{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </x-filter-accordion>

        <x-table :targets="[]" :paginator="$userPaginator">
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

            <x-slot:tbody>
                @forelse ($userPaginator as $user)
                    @php
                        $userName = $user->name ?? '-';
                        $roleName = $user->roles->first()?->name;
                        $maskedEmail = filled($user->email) ? \Illuminate\Support\Str::mask($user->email, '*', 3) : '-';
                        $createdAtLabel = $user->created_at?->translatedFormat('d F Y H:i') ?? '-';
                    @endphp

                    <tr wire:key="user-{{ $user->id }}">
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

                        <td class="py-3 align-middle">
                            <div class="font-weight-bold mb-2">{{ $userName }}</div>

                            @if (filled($roleName))
                                <div class="d-flex align-items-center flex-wrap">
                                    <x-badge :label="$roleName" icon="fa-shield-alt" variant="primary" class="mb-1" />
                                </div>
                            @endif
                        </td>

                        <td class="py-3 align-middle">
                            <span class="font-weight-bold">{{ $maskedEmail }}</span>
                        </td>

                        <td class="py-3 align-middle">
                            <span class="text-muted">{{ $createdAtLabel }}</span>
                        </td>

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
                                        wire:confirm="Yakin ingin menghapus pengguna '{{ $userName }}'?"
                                        wire:loading.attr="disabled"
                                        wire:target="destroy({{ $user->id }})"
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
