@php
    $logs = $this->activityLogs;
    $showDetailModal = $activeModal === 'show' && filled($modalParams['id'] ?? null);
    $detailLogId = $modalParams['id'] ?? null;
@endphp

<div>
    @if ($showDetailModal)
        @teleport('body')
            <livewire:pages::activity-logs.show :auditLogId="$detailLogId" wire:key="modal-show-{{ $detailLogId }}" />
        @endteleport
    @endif

    <x-page :searchable="true">
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

        <x-table :targets="[]" :paginator="$logs">
            <x-slot:thead>
                <tr>
                    <th scope="col" style="width: 180px">Waktu</th>
                    <th scope="col">Pengguna</th>
                    <th scope="col">Aktivitas</th>
                    <th scope="col">IP Address</th>
                    <th scope="col" class="text-center" style="width: 80px">Aksi</th>
                </tr>
            </x-slot:thead>

            <x-slot:tbody>
                @forelse ($logs as $log)
                    @php
                        $eventLabel = ucfirst((string) ($log->event ?? $log->action ?? 'Aktivitas'));
                        $causerName = $log->causer?->name ?? 'Sistem';
                        $causerEmail = $log->causer?->email;
                        $formattedDate = $log->created_at?->translatedFormat('d M Y') ?? '-';
                        $formattedTime = $log->created_at?->format('H:i:s') ?? '-';
                    @endphp

                    <tr wire:key="audit-log-{{ $log->id }}">
                        <td class="align-middle text-nowrap">
                            <div>{{ $formattedDate }}</div>
                            <small class="text-muted">{{ $formattedTime }}</small>
                        </td>

                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $causerName }}</div>
                            @if (filled($causerEmail))
                                <small class="text-muted">{{ $causerEmail }}</small>
                            @endif
                        </td>

                        <td class="py-3 align-middle">
                            <div class="mb-1">
                                <x-badge :label="$eventLabel" variant="info" />
                            </div>
                            <div class="text-dark">{{ $log->description ?? '-' }}</div>
                        </td>

                        <td class="align-middle text-nowrap">
                            <code>{{ $log->ip_address ?? '-' }}</code>
                        </td>

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
