<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\CommodityLocation;
use App\SchoolOperationalAssistance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\Commodities\Excel\Export;
use App\Http\Requests\CommodityImportRequest;
use App\Http\Requests\StoreCommodityRequest;
use App\Http\Requests\UpdateCommodityRequest;
use App\Imports\CommoditiesImport;
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
    public function store(StoreCommodityRequest $request)
    {
        Commodity::create($request->validated());

        return to_route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommodityRequest $request, Commodity $commodity)
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
        $pdf = Pdf::loadView('commodities.pdf', compact(['commodities', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    public function generatePDFIndividually($id)
    {
        $commodity = Commodity::find($id);
        $sekolah = env('NAMA_SEKOLAH', 'Barang Milik Sekolah');
        $pdf = Pdf::loadView('commodities.pdfone', compact(['commodity', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    public function export()
    {
        $commodities = Commodity::all();

        if (count($commodities) != 0)
            return Excel::download(new Export, 'daftar-barang-' . date('d-m-Y') . '.xlsx');
        return redirect()->back()->withInput()->withErrors('Tidak ada Barang');
    }

    public function import(CommodityImportRequest $request)
    {
        Excel::import(new CommoditiesImport, $request->file('file'));

        return to_route('barang.index')->with('success', 'Data barang berhasil diimpor!');
    }
}
