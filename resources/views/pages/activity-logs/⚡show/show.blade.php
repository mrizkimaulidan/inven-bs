<x-modal title="Detail Log Aktivitas" size="lg" :scrollable="true">
    <x-slot:body>
        {{-- Ringkasan aktivitas --}}
        <div class="mb-4">
            <div class="d-flex align-items-center mb-2 flex-wrap">
                <x-badge :label="str($auditLog->event)->headline()" variant="info" class="mr-2 mb-1" />
                @if ($auditLog->log_name)
                    <x-badge :label="$auditLog->log_name" variant="secondary" class="mr-2 mb-1" />
                @endif
                <small class="text-muted mb-1">
                    {{ $auditLog->created_at->translatedFormat('d M Y, H:i:s') }} ({{ $auditLog->created_at->diffForHumans() }})
                </small>
            </div>

            <h5 class="font-weight-bold mb-1">{{ $auditLog->description }}</h5>
            @if ($auditLog->subject_label || $auditLog->subject_type)
                <div class="text-muted">
                    Objek:
                    <strong>
                        {{ $auditLog->subject_label ?? (class_basename($auditLog->subject_type) . ' #' . $auditLog->subject_id) }}
                    </strong>
                    @if ($auditLog->subject_type && $auditLog->subject_id)
                        <small class="ml-1">({{ class_basename($auditLog->subject_type) }} ID: {{ $auditLog->subject_id }})</small>
                    @endif
                </div>
            @endif
        </div>

        <hr />

        {{-- Pelaku & Konteks Request --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-uppercase text-muted font-weight-bold mb-0">Informasi Pelaku & Request</h6>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <small class="text-muted d-block mb-1">Pelaku</small>
                    <div class="font-weight-bold">{{ $auditLog->causer_name ?? 'Sistem' }}</div>
                    @if ($auditLog->causer_type || $auditLog->causer_id)
                        <small class="text-muted">
                            {{ $auditLog->causer_type ? class_basename($auditLog->causer_type) : 'System' }}
                            @if ($auditLog->causer_id)
                                · ID: {{ $auditLog->causer_id }}
                            @endif
                        </small>
                    @endif
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="h-100 rounded border p-3">
                    <small class="text-muted d-block mb-1">IP Address</small>
                    <div class="font-weight-bold">
                        <code>{{ $auditLog->ip_address ?? '-' }}</code>
                    </div>
                    <small class="text-muted">Alamat IP saat aksi terjadi</small>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="rounded border p-3">
                    <small class="text-muted d-block mb-1">Request URL</small>
                    <div class="text-break">
                        <code>{{ $auditLog->request_url ?? '-' }}</code>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="rounded border p-3">
                    <small class="text-muted d-block mb-1">User Agent</small>
                    <small class="text-muted text-break d-block"> {{ $auditLog->user_agent ?? '-' }} </small>
                </div>
            </div>
        </div>

        {{-- Perubahan Data (Diff) --}}
        @php
            $diff = is_array($auditLog->diff) ? $auditLog->diff : json_decode($auditLog->diff ?? 'null', true);

            $formatDiffValue = function ($val): string {
                if (is_null($val)) {
                    return '-';
                }
                if (is_bool($val)) {
                    return $val ? 'true' : 'false';
                }
                if (is_scalar($val)) {
                    return (string) $val;
                }

                return json_encode($val, JSON_UNESCAPED_UNICODE) ?: '-';
            };
        @endphp

        @if (! empty($diff) && is_array($diff))
            <hr />

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-uppercase text-muted font-weight-bold mb-0">Perubahan Data (Diff)</h6>
            </div>

            <div class="table-responsive mb-3">
                <table class="table-bordered table-sm mb-0 table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 25%">Field</th>
                            <th style="width: 37.5%">Sebelum</th>
                            <th style="width: 37.5%">Sesudah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($diff as $field => $changes)
                            @php
                                $oldVal = is_array($changes) ? ($changes['old'] ?? $changes['before'] ?? null) : null;
                                $newVal = is_array($changes) ? ($changes['new'] ?? $changes['after'] ?? $changes) : $changes;
                            @endphp
                            <tr>
                                <td class="font-weight-bold"><code>{{ $field }}</code></td>
                                <td class="text-danger text-break">{{ $formatDiffValue($oldVal) }}</td>
                                <td class="text-success text-break">{{ $formatDiffValue($newVal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Properties tambahan --}}
        @php
            $properties = is_array($auditLog->properties) ? $auditLog->properties : json_decode($auditLog->properties ?? 'null', true);
        @endphp

        @if (! empty($properties))
            <hr />

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-uppercase text-muted font-weight-bold mb-0">Properties</h6>
            </div>

            <div class="bg-light rounded border p-3">
                <pre
                    class="text-dark mb-0"
                    style="max-height: 240px; overflow: auto"
                ><code>{{ json_encode($properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        @endif
    </x-slot:body>
</x-modal>
