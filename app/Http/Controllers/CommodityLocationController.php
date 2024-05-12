<?php

namespace App\Http\Controllers;

use App\CommodityLocation;
use App\Exports\CommodityLocationsExport;
use App\Http\Requests\CommodityLocationImportRequest;
use App\Http\Requests\StoreCommodityLocationRequest;
use App\Http\Requests\UpdateCommodityLocationRequest;
use App\Imports\CommodityLocationsImport;
use Maatwebsite\Excel\Facades\Excel;

class CommodityLocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CommodityLocation::class, 'commodity_location');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodity_locations = CommodityLocation::orderBy('name', 'ASC')->get();

        return view('commodity-locations.index', compact('commodity_locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommodityLocationRequest $request)
    {
        CommodityLocation::create($request->validated());

        return to_route('ruangan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommodityLocationRequest $request, CommodityLocation $commodityLocation)
    {
        $commodityLocation->update($request->all());

        return to_route('ruangan.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommodityLocation $commodityLocation)
    {
        if ($commodityLocation->commodities->isNotEmpty()) {
            return to_route('ruangan.index')
                ->with('error', 'Ruangan tidak dapat dihapus karena masih terkait dengan data komoditas!');
        }

        $commodityLocation->delete();

        return to_route('ruangan.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Export commodities data to Excel.
     */
    public function export()
    {
        return Excel::download(new CommodityLocationsExport, 'daftar-ruangan-' . date('d-m-Y') . '.xlsx');
    }

    /**
     * Import commodity locations data from Excel.
     */
    public function import(CommodityLocationImportRequest $request)
    {
        Excel::import(new CommodityLocationsImport, $request->file('file'));

        return to_route('ruangan.index')->with('success', 'Data ruangan berhasil diimpor!');
    }
}
