@php
    $reportTitle = filled($title ?? null) ? (string) $title : 'Laporan Data';
    $printedLabel = filled($printedAt ?? null) ? (string) $printedAt : '-';
    $columnHeaders = is_array($headers ?? null)
        ? $headers
        : (is_iterable($headers ?? null) ? collect($headers)->all() : []);
    $rowItems = is_array($rows ?? null)
        ? collect($rows)
        : (is_iterable($rows ?? null) ? collect($rows) : collect());
    $rowCount = $rowItems->count();
    $colspanCount = max(1, count($columnHeaders) + 1);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>{{ $reportTitle }}</title>
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
    <h1>{{ $reportTitle }}</h1>
    <p class="print-meta">Dicetak: {{ $printedLabel }} &mdash; Total: {{ $rowCount }} data</p>

    <table>
        <thead>
            <tr>
                <th style="width: 36px">No.</th>
                @foreach ($columnHeaders as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rowItems as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ((array) $row as $value)
                        <td>{{ filled($value) || $value === 0 || $value === '0' ? $value : '-' }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ $colspanCount }}">Belum ada data untuk dicetak.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Dokumen dicetak dari sistem inventaris.</p>
</body>
</html>
