<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #222;
        }

        h1 {
            margin: 0 0 4px;
            text-align: center;
            font-size: 18px;
        }

        .print-meta {
            margin: 0 0 14px;
            text-align: center;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #e9ecef;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }

        .empty {
            text-align: center;
            color: #555;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="print-meta">Dicetak {{ $printedAt }} — Total {{ $rows->count() }} data</p>

    <table>
        <thead>
            <tr>
                <th style="width: 36px">No.</th>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @foreach ($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ count($headers) + 1 }}">Belum ada data untuk dicetak.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Dokumen dicetak dari sistem inventaris.</p>
</body>
</html>
