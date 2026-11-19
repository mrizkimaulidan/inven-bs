<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Barang</title>
    <style>
        @page {
            margin: 8mm;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        /* Grid 2 kolom */
        table.grid {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 6px 8px;
        }

        table.grid > tbody > tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* Setiap sel = satu kartu */
        td.cell {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        /* Kartu barang */
        table.card {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        table.card th,
        table.card td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            word-wrap: break-word;
        }

        .qr-wrapper img {
            width: 100px;
            height: 100px;
            display: block;
            margin: 0 auto;
        }

        .scan-hint {
            font-size: 9px;
            margin-top: 3px;
            color: #333;
        }

        .printed-at {
            font-size: 10px;
            margin-top: 12px;
            color: #333;
        }
    </style>
</head>
<body>
    @forelse ($commodities->chunk(6) as $pageChunk)
        <table @class(['grid', 'page-break' => ! $loop->last])>
            <colgroup>
                <col style="width: 50%" />
                <col style="width: 50%" />
            </colgroup>
            <tbody>
                @foreach ($pageChunk->chunk(2) as $rowChunk)
                    <tr>
                        @foreach ($rowChunk as $commodity)
                            <td class="cell">
                                <table class="card">
                                    <colgroup>
                                        <col style="width: 35%" />
                                        <col style="width: 65%" />
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <td>{{ $commodity->item_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <td>{{ $commodity->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Asal Perolehan</th>
                                            <td>{{ $commodity->commodityFundingSource->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>QR Code</th>
                                            <td class="qr-wrapper">
                                                @if (($qrCodes[$commodity->id] ?? null) !== null)
                                                    {{ $qrCodes[$commodity->id] }}
                                                    <div class="scan-hint">Scan untuk verifikasi</div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        @endforeach

                        {{-- Kalau jumlah ganjil, isi sel kosong biar layout tidak berantakan --}}
                        @if ($rowChunk->count() === 1)
                            <td class="cell"></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>Tidak ada data barang.</p>
    @endforelse

    <p class="printed-at">Dicetak: {{ now()->format('d/m/Y H:i') }} — Total: {{ $commodities->count() }} item</p>
</body>
</html>
