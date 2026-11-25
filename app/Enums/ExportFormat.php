<?php

namespace App\Enums;

use Maatwebsite\Excel\Excel;

/**
 * Represent supported export formats and resolve their writer types.
 */
enum ExportFormat: string
{
    case Xlsx = 'xlsx';
    case Xls = 'xls';
    case Csv = 'csv';
    case Tsv = 'tsv';
    case Ods = 'ods';
    case Html = 'html';

    /**
     * Get the Maatwebsite Excel writer type constant for this format.
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
     * Get the human-readable label for display in UI controls.
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
     * Get the file extension for this format.
     */
    public function extension(): string
    {
        return $this->value;
    }

    /**
     * Get all enum cases for rendering in a view.
     *
     * @return list<self>
     */
    public static function options(): array
    {
        return self::cases();
    }

    /**
     * Get all supported format values for validation rules.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
