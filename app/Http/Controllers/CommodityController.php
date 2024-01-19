<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\CommodityLocation;
use App\SchoolOperationalAssistance;
use PDF;
use Illuminate\Http\Request;
use App\Exports\Commodities\Excel\Export;
use App\Imports\Commodities\Excel\Import;
use Maatwebsite\Excel\Facades\Excel;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = Commodity::latest()->get();
        $school_operational_assistances = SchoolOperationalAssistance::orderBy('name', 'ASC')->get();
        $commodity_locations = CommodityLocation::orderBy('name', 'ASC')->get();

        return view('commodities.index', compact('commodities', 'school_operational_assistances', 'commodity_locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Commodity::create($request->all());

        return to_route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commodity $commodity)
    {
        $commodity->update($request->all());

        return to_route('barang.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commodity $commodity)
    {
        $commodity->delete();

        return to_route('barang.index')->with('success', 'Data berhasil dihapus!');
    }

    public function generatePDF()
    {
        $commodities = Commodity::all();
        $sekolah = env('NAMA_SEKOLAH', 'Barang Milik Sekolah');
        $pdf = PDF::loadView('commodities.pdf', compact(['commodities', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    public function generatePDFIndividually($id)
    {
        $commodity = Commodity::find($id);
        $sekolah = env('NAMA_SEKOLAH', 'Barang Milik Sekolah');
        $pdf = PDF::loadView('commodities.pdfone', compact(['commodity', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    public function export()
    {
        $commodities = Commodity::all();

        if (count($commodities) != 0)
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
