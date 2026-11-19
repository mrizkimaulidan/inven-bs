<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Detail Barang</title>
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

        table {
            width: 55%;
            margin: 0 auto;
            table-layout: fixed;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            word-wrap: break-word;
        }

        .qr-wrapper img {
            width: 120px;
            height: 120px;
            display: block;
            margin: 0 auto;
        }

        .scan-hint {
            font-size: 10px;
            margin-top: 4px;
            color: #333;
        }

        .printed-at {
            font-size: 10px;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <table>
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
                    @if ($qrCode !== null)
                        {{ $qrCode }}
                        <div class="scan-hint">Scan untuk verifikasi</div>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <p class="printed-at">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
