<?php

namespace App\Http\Controllers\Commodities;

use App\Http\Controllers\Controller;
use App\Exports\Commodities\Excel\Export;
use App\Imports\Commodities\Excel\Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CommodityExportImportController extends Controller
{
    public function export()
    {
        return Excel::download(new Export, 'daftar-barang-' . date('d-m-Y') . '.xlsx');
    }

    public function import()
    {
        Excel::import(new Import, request()->file('file'));

        return back();
    }
}
