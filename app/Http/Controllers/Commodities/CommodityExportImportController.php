<?php

namespace App\Http\Controllers\Commodities;

use App\Http\Controllers\Controller;
use App\Exports\Commodities\Excel\Export;
use App\Imports\Commodities\Excel\Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Commodity;

class CommodityExportImportController extends Controller
{
    public function export()
    {
        $commodities = Commodity::all();
        
        if(count($commodities)!=0)
            return Excel::download(new Export, 'daftar-barang-' . date('d-m-Y') . '.xlsx');
        return redirect()->back()->withInput()->withErrors('Tidak ada Barang');
    }

    public function import()
    {
        try {
            Excel::import(new Import, request()->file('file'));
            return redirect()->back()->with('sukses', 'Import barang Berhasil');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal, Pastikan Import Data Anda Sesuai');
        }
    }
}
