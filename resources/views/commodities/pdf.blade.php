<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Barang</title>
    <style>
        @page {
            margin: 8mm;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            width: 35%;
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
                <td>{{ $commodity->commodityFundingSource->name }}</td>
            </tr>
            <tr>
                <th>QR Code</th>
                <td>
                    {{ $qrCode }}
                    <div class="scan-hint">Scan untuk verifikasi</div>
                </td>
            </tr>
        </tbody>
    </table>

    <p class="printed-at">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>
