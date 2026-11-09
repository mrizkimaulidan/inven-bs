{{-- ===== START: Recent Items Table ===== --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Barang Terbaru</h4>
                <div class="card-header-action">
                    <span class="text-muted small">5 pencatatan terakhir</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-striped table-hover mb-0 table">
                        <caption class="sr-only">
                            Lima data barang terbaru
                        </caption>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Merek &amp; Bahan</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Tahun Pembelian</th>
                                <th scope="col">Tanggal Pencatatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="text-nowrap">{{ $item->item_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->brand?->name ?? '—' }} / {{ $item->material?->name ?? '—' }}</td>
                                    <td>{{ $item->commodityLocation?->name ?? '—' }}</td>
                                    <td class="text-center">{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <x-badge
                                            :label="$item->condition->label()"
                                            :variant="$this->conditionVariant($item->condition)"
                                        />
                                    </td>
                                    <td>{{ $item->purchase_year }}</td>
                                    <td class="text-nowrap">
                                        {{ $item->created_at->locale('id')->translatedFormat('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted py-4 text-center">
                                        Belum ada data barang untuk filter yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ===== END: Recent Items Table ===== --}}
