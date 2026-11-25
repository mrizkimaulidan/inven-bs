@php
    $trimmedSearch = is_string($search) ? trim($search) : '';
    $isSearching = $hasSearch();
@endphp

{{-- Empty state row for a table. Must be rendered inside a <tr>. --}}
<td colspan="{{ $colspan }}" class="py-5 text-center">
    <div class="py-3">
        <i class="fas {{ $isSearching ? 'fa-search' : 'fa-inbox' }} fa-2x text-muted mb-3" aria-hidden="true"></i>

        <h5 class="font-weight-bold">
            @if ($isSearching)
                Hasil Pencarian Tidak Ditemukan
            @else
                Belum Ada Data
            @endif
        </h5>

        <p class="text-muted mb-3">
            @if ($isSearching)
                Tidak ditemukan data dengan kata kunci
                <strong>"{{ $trimmedSearch }}"</strong>
            @else
                Belum ada data yang terdaftar di sistem
            @endif
        </p>
    </div>
</td>
