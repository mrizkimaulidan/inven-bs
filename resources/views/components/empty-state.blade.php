{{-- Empty state row for a table. Must be rendered inside a <tr>. --}}
<td colspan="{{ $colspan }}" class="py-5 text-center">
    <div class="py-3">
        {{-- Visual cue for the empty state. --}}
        <i class="fas {{ $hasSearch() ? 'fa-search' : 'fa-inbox' }} fa-2x text-muted mb-3"></i>

        {{-- Heading. --}}
        <h5 class="font-weight-bold">
            @if ($hasSearch())
                Hasil Pencarian Tidak Ditemukan
            @else
                Belum Ada Data
            @endif
        </h5>

        {{-- Description. --}}
        <p class="text-muted mb-3">
            @if ($hasSearch())
                Tidak ditemukan data dengan kata kunci
                <strong>"{{ $search }}"</strong>
            @else
                Belum ada data yang terdaftar di sistem
            @endif
        </p>
    </div>
</td>
