<?php

namespace App\Enums;

use Maatwebsite\Excel\Excel;

enum ExportFormat: string
{
    case Xlsx = 'xlsx';
    case Xls = 'xls';
    case Csv = 'csv';
    case Tsv = 'tsv';
    case Ods = 'ods';
    case Html = 'html';

    /**
     * Get the writer type constant for the export.
     */
    public function writerType(): string
    {
        return match ($this) {
            self::Xlsx => Excel::XLSX,
            self::Xls => Excel::XLS,
            self::Csv => Excel::CSV,
            self::Tsv => Excel::TSV,
            self::Ods => Excel::ODS,
            self::Html => Excel::HTML,
        };
    }

    /**
     * Get the human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Xlsx => '.xlsx — Excel Spreadsheet',
            self::Xls => '.xls — Excel 97-2003',
            self::Csv => '.csv — Comma Separated Values',
            self::Tsv => '.tsv — Tab Separated Values',
            self::Ods => '.ods — OpenDocument Spreadsheet',
            self::Html => '.html — HTML Table',
        };
    }

    /**
     * Get all cases for rendering in a view.
     *
     * @return array<int, self>
     */
    public static function options(): array
    {
        return self::cases();
    }
}
