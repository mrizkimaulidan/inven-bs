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
                                <th scope="col">Ruangan</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Tahun Pembelian</th>
                                <th scope="col">Tanggal Pencatatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items ?? [] as $item)
                                @php
                                    $brandName = $item->brand?->name ?? '—';
                                    $materialName = $item->material?->name ?? '—';
                                    $locationName = $item->commodityLocation?->name ?? '—';
                                    $quantity = (int) ($item->quantity ?? 0);
                                    $conditionLabel = $item->condition?->label() ?? '—';
                                    $conditionVariant = $item->condition !== null
                                        ? $this->conditionVariant($item->condition)
                                        : 'secondary';
                                    $createdDate = $item->created_at?->locale('id')->translatedFormat('d M Y') ?? '—';
                                @endphp

                                <tr wire:key="recent-item-{{ $item->id ?? $loop->index }}">
                                    <td class="text-nowrap">{{ $item->item_code ?? '—' }}</td>
                                    <td>{{ $item->name ?? '—' }}</td>
                                    <td>{{ $brandName }} / {{ $materialName }}</td>
                                    <td>{{ $locationName }}</td>
                                    <td class="text-center">{{ number_format($quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <x-badge :label="$conditionLabel" :variant="$conditionVariant" />
                                    </td>
                                    <td>{{ $item->purchase_year ?? '—' }}</td>
                                    <td class="text-nowrap">{{ $createdDate }}</td>
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
