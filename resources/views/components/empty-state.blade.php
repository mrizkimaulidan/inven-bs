<div>
    <td colspan="{{ $colspan }}" class="py-5 text-center">
        <div class="py-4">
            <h5 class="font-weight-bold">
                @if (filled($search))
                    Hasil Pencarian Tidak Ditemukan
                @else
                    Belum Ada Data
                @endif
            </h5>
            <p class="text-muted mb-3">
                @if (filled($search))
                    Tidak ditemukan data dengan kata kunci "<strong
                    >{{ $search }}</strong
                    >"
                @else
                    Belum ada data yang terdaftar di sistem
                @endif
            </p>
        </div>
    </td>
</div>
