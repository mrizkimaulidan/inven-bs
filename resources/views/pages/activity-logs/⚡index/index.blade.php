<div>
    {{-- Modal dialogs --}}
    @if ($activeModal === 'show')
        @teleport('body')
            <livewire:pages::activity-logs.show
                :auditLogId="$modalParams['id']"
                wire:key="modal-show-{{ $modalParams['id'] }}"
            />
        @endteleport
    @endif

    {{-- Listing page --}}
    <x-page :searchable="true">
        {{-- Toolbar actions --}}
        <x-slot:toolbar>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap">
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
            </div>
        </x-slot:toolbar>

        {{-- Data table --}}
        <x-table :targets="[]" :paginator="$this->activityLogs">
            {{-- Table headings --}}
            <x-slot:thead>
                <tr>
                    <th scope="col" style="width: 180px">Waktu</th>
                    <th scope="col">Pengguna</th>
                    <th scope="col">Aktivitas</th>
                    <th scope="col">IP Address</th>
                    <th scope="col" class="text-center" style="width: 80px">Aksi</th>
                </tr>
            </x-slot:thead>

            {{-- Table rows --}}
            <x-slot:tbody>
                @forelse ($this->activityLogs as $log)
                    <tr wire:key="audit-log-{{ $log->id }}">
                        {{-- Waktu --}}
                        <td class="align-middle text-nowrap">
                            <div>{{ $log->created_at->translatedFormat('d M Y') }}</div>
                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                        </td>

                        {{-- Pengguna --}}
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $log->causer->name ?? 'Sistem' }}</div>
                            @if ($log->causer?->email)
                                <small class="text-muted">{{ $log->causer->email }}</small>
                            @endif
                        </td>

                        {{-- Aktivitas / Event & Deskripsi --}}
                        <td class="py-3 align-middle">
                            <div class="mb-1">
                                <x-badge :label="ucfirst($log->event ?? $log->action ?? 'Aktivitas')" variant="info" />
                            </div>
                            <div class="text-dark">{{ $log->description ?? '-' }}</div>
                        </td>

                        {{-- IP Address --}}
                        <td class="align-middle text-nowrap">
                            <code>{{ $log->ip_address ?? '-' }}</code>
                        </td>

                        {{-- Aksi (Detail Only) --}}
                        <td class="text-center align-middle">
                            <div class="btn-group table-action-group" role="group" aria-label="Aksi log aktivitas">
                                @can('detail log aktivitas')
                                    <x-button
                                        label=""
                                        icon="fa-search"
                                        variant="info"
                                        class="btn-sm"
                                        wire:click="$dispatch('showModal', {modalName: 'show', params: {id: {{ $log->id }}}})"
                                        aria-label="Detail log aktivitas"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Detail"
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
