@php
    $diffRows = $this->diffItems;
    $prettyProperties = $this->formattedProperties;
    $createdAt = $auditLog?->created_at;
    $formattedTimestamp = $createdAt?->translatedFormat('d M Y, H:i:s') ?? '-';
    $relativeTimestamp = $createdAt?->diffForHumans();
    $subjectBasename = filled($auditLog?->subject_type)
        ? class_basename((string) $auditLog->subject_type)
        : null;
    $causerBasename = filled($auditLog?->causer_type)
        ? class_basename((string) $auditLog->causer_type)
        : 'System';
@endphp

<x-modal title="Detail Log Aktivitas" size="lg" :scrollable="true">
    <x-slot:body>
        <div class="bg-light mb-4 rounded border p-3">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                <div class="d-flex align-items-center mb-1 flex-wrap">
                    <x-badge
                        :label="str((string) ($auditLog?->event ?? 'aktivitas'))->headline()"
                        variant="info"
                        class="mr-2"
                    />
                    @if (filled($auditLog?->log_name))
                        <x-badge
                            :label="str((string) $auditLog->log_name)->headline()"
                            variant="secondary"
                            class="mr-2"
                        />
                    @endif
                </div>

                <small class="text-muted mb-1">
                    <i class="far fa-clock mr-1" aria-hidden="true"></i>
                    {{ $formattedTimestamp }}
                    @if ($relativeTimestamp)
                        <span class="d-none d-sm-inline">&middot; {{ $relativeTimestamp }}</span>
                    @endif
                </small>
            </div>

            <h5 class="font-weight-bold text-dark mb-2">{{ $auditLog?->description ?? '-' }}</h5>

            @if (filled($auditLog?->subject_label) || $subjectBasename)
                <div class="d-flex align-items-center text-muted small border-top flex-wrap pt-2">
                    <i class="fas fa-cube text-primary mr-2" aria-hidden="true"></i>
                    <span class="mr-1">Objek Terkait:</span>
                    <strong class="text-dark mr-2">
                        {{ $auditLog?->subject_label ?? ($subjectBasename . ($auditLog?->subject_id ? ' #' . $auditLog->subject_id : '')) }}
                    </strong>
                    @if ($subjectBasename && filled($auditLog?->subject_id))
                        <span class="badge badge-light text-muted border">
                            {{ $subjectBasename }} #{{ $auditLog->subject_id }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <span class="badge badge-primary mr-2 p-2">
                    <i class="fas fa-fingerprint" aria-hidden="true"></i>
                </span>
                <div>
                    <h6 class="font-weight-bold text-dark mb-0">Pelaku &amp; Konteks Request</h6>
                    <small class="text-muted">Identitas pengguna dan informasi jaringan saat aktivitas terjadi</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user-circle text-primary mr-2" aria-hidden="true"></i>
                            <small class="text-uppercase font-weight-bold text-muted">Pelaku</small>
                        </div>
                        <div class="font-weight-bold text-dark">{{ $auditLog?->causer_name ?? 'Sistem' }}</div>
                        @if (filled($auditLog?->causer_type) || filled($auditLog?->causer_id))
                            <small class="text-muted d-block mt-1">
                                {{ $causerBasename }}
                                @if (filled($auditLog?->causer_id))
                                    &middot; ID: {{ $auditLog->causer_id }}
                                @endif
                            </small>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="h-100 rounded border p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-network-wired text-info mr-2" aria-hidden="true"></i>
                            <small class="text-uppercase font-weight-bold text-muted">IP Address</small>
                        </div>
                        <div class="font-weight-bold">
                            <code>{{ $auditLog?->ip_address ?? '-' }}</code>
                        </div>
                        <small class="text-muted d-block mt-1">Alamat IP sumber request</small>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="rounded border p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-link text-secondary mr-2" aria-hidden="true"></i>
                            <small class="text-uppercase font-weight-bold text-muted">Request URL</small>
                        </div>
                        <div class="text-break bg-light rounded px-2 py-1">
                            <code class="small">{{ $auditLog?->request_url ?? '-' }}</code>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-0">
                    <div class="rounded border p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-laptop text-muted mr-2" aria-hidden="true"></i>
                            <small class="text-uppercase font-weight-bold text-muted">User Agent</small>
                        </div>
                        <small class="text-muted text-break d-block">{{ $auditLog?->user_agent ?? '-' }}</small>
                    </div>
                </div>
            </div>
        </div>

        @if ($diffRows !== [])
            <hr class="my-4" />

            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-warning text-dark mr-2 p-2">
                            <i class="fas fa-right-left" aria-hidden="true"></i>
                        </span>
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0">Perubahan Data (Diff)</h6>
                            <small class="text-muted">Perbandingan nilai field sebelum dan sesudah perubahan</small>
                        </div>
                    </div>
                    <span class="badge badge-light text-muted mt-sm-0 mt-1 border">
                        {{ count($diffRows) }} field berubah
                    </span>
                </div>

                <div class="table-responsive rounded border">
                    <table class="table-hover table-sm mb-0 table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 24%">Field</th>
                                <th scope="col" style="width: 38%">
                                    <i class="fas fa-circle-minus text-danger mr-1" aria-hidden="true"></i>
                                    Sebelum
                                </th>
                                <th scope="col" style="width: 38%">
                                    <i class="fas fa-circle-plus text-success mr-1" aria-hidden="true"></i>
                                    Sesudah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diffRows as $item)
                                <tr wire:key="diff-item-{{ $loop->index }}">
                                    <td class="font-weight-bold align-middle">
                                        <code>{{ $item['field'] }}</code>
                                    </td>
                                    <td class="text-danger text-break align-middle">{{ $item['old'] }}</td>
                                    <td class="text-success text-break align-middle">{{ $item['new'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if (filled($prettyProperties))
            <hr class="my-4" />

            <div>
                <div class="d-flex align-items-center mb-3">
                    <span class="badge badge-secondary mr-2 p-2">
                        <i class="fas fa-sliders" aria-hidden="true"></i>
                    </span>
                    <div>
                        <h6 class="font-weight-bold text-dark mb-0">Properties Tambahan</h6>
                        <small class="text-muted">Data metadata JSON yang tersimpan pada log</small>
                    </div>
                </div>

                <div class="bg-light rounded border p-3">
                    <pre
                        class="text-dark small mb-0"
                        style="max-height: 240px; overflow: auto"
                    ><code>{{ $prettyProperties }}</code></pre>
                </div>
            </div>
        @endif
    </x-slot:body>
</x-modal>
