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
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px;
        }

        /* Grid 2 kolom */
        table.grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 8px;
        }

        /* Setiap sel = satu kartu. Jangan terpotong antar halaman */
        td.cell {
            width: 50%;
            vertical-align: top;
            page-break-inside: avoid;
            break-inside: avoid;
            padding: 0;
        }

        /* Kartu barang */
        table.card {
            width: 100%;
            border-collapse: collapse;
        }

        table.card th,
        table.card td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }

        table.card th {
            width: 35%;
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
    <table class="grid">
        <tbody>
            @foreach ($commodities->chunk(2) as $chunk)
                <tr>
                    @foreach ($chunk as $commodity)
                        <td class="cell">
                            <table class="card">
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
                                        <td>
                                            @if ($qrCodes[$commodity->id] !== null)
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

                    {{-- kalau jumlah ganjil, isi sel kosong biar layout tidak berantakan --}}
                    @if ($chunk->count() === 1)
                        <td class="cell"></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="printed-at">Dicetak: {{ now()->format('d/m/Y H:i') }} — Total: {{ $commodities->count() }} item</p>
</body>
</html>
