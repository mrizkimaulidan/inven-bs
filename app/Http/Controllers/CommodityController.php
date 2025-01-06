<?php

namespace App\Http\Controllers;

use App\Commodity;
use App\CommodityAcquisition;
use App\CommodityLocation;
use App\Exports\CommoditiesExport;
use App\Http\Requests\CommodityExportRequest;
use App\Http\Requests\CommodityImportRequest;
use App\Http\Requests\StoreCommodityRequest;
use App\Http\Requests\UpdateCommodityRequest;
use App\Imports\CommoditiesImport;
use App\Repositories\CommodityRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CommodityController extends Controller
{
    public function __construct(
        private CommodityRepository $commodityRepository,
    ) {
        $this->authorizeResource(Commodity::class, 'commodity');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Commodity::query()->with('commodity_location', 'commodity_acquisition');
        $query->when(request()->filled('condition'), function ($q) {
            return $q->where('condition', request('condition'));
        });

        $query->when(request()->filled('commodity_location_id'), function ($q) {
            return $q->where('commodity_location_id', request('commodity_location_id'));
        });

        $query->when(request()->filled('commodity_acquisition_id'), function ($q) {
            return $q->where('commodity_acquisition_id', request('commodity_acquisition_id'));
        });

        $query->when(request()->filled('year_of_purchase'), function ($q) {
            return $q->where('year_of_purchase', request('year_of_purchase'));
        });

        $query->when(request()->filled('material'), function ($q) {
            return $q->where('material', request('material'));
        });

        $query->when(request()->filled('brand'), function ($q) {
            return $q->where('brand', request('brand'));
        });

        $commodities = $query->latest()->get();
        $year_of_purchases = Commodity::pluck('year_of_purchase')->unique()->sort();
        $commodity_brands = Commodity::pluck('brand')->unique()->sort();
        $commodity_materials = Commodity::pluck('material')->unique()->sort();
        $commodity_acquisitions = CommodityAcquisition::orderBy('name', 'ASC')->get();
        $commodity_locations = CommodityLocation::orderBy('name', 'ASC')->get();

        $commodity_condition_count = $this->commodityRepository->countCommodityCondition()->map(function ($commodity) {
            return collect([
                'condition_name' => $commodity->getConditionName(),
                'count' => $commodity->count,
            ]);
        });

        $commodity_counts = [
            'commodity_in_total' => $commodity_condition_count->sum('count') ?? 0,
            'commodity_in_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Baik')['count'] ?? 0,
            'commodity_in_not_good_condition' => $commodity_condition_count->firstWhere('condition_name', 'Kurang Baik')['count'] ?? 0,
            'commodity_in_heavily_damage_condition' => $commodity_condition_count->firstWhere('condition_name', 'Rusak Berat')['count'] ?? 0,
        ];

        return view(
            'commodities.index',
            compact(
                'commodities',
                'commodity_acquisitions',
                'commodity_locations',
                'year_of_purchases',
                'commodity_brands',
                'commodity_materials',
                'commodity_counts'
            )
        );
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

    /**
     * Generate PDF for all commodities.
     */
    public function generatePDF()
    {
        $this->authorize('print barang');

        $commodities = Commodity::all();
        $sekolah = env('NAMA_SEKOLAH', 'Barang Milik Sekolah');
        $pdf = Pdf::loadView('commodities.pdf', compact(['commodities', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    /**
     * Generate PDF for a specific commodity.
     */
    public function generatePDFIndividually($id)
    {
        $this->authorize('print individual barang');

        $commodity = Commodity::find($id);
        $sekolah = env('NAMA_SEKOLAH', 'Barang Milik Sekolah');
        $pdf = Pdf::loadView('commodities.pdfone', compact(['commodity', 'sekolah']))->setPaper('a4');

        return $pdf->download('print.pdf');
    }

    /**
     * Export commodities data to Excel.
     */
    public function export(CommodityExportRequest $request)
    {
        $this->authorize('export barang');

        $filename = 'daftar-barang-'.date('d-m-Y');

        return match ($request->extension) {
            'xlsx' => Excel::download(new CommoditiesExport, $filename.'.xlsx', \Maatwebsite\Excel\Excel::XLSX),
            'xls' => Excel::download(new CommoditiesExport, $filename.'.xls', \Maatwebsite\Excel\Excel::XLS),
            'csv' => Excel::download(new CommoditiesExport, $filename.'.csv', \Maatwebsite\Excel\Excel::CSV),
            'html' => Excel::download(new CommoditiesExport, $filename.'.html', \Maatwebsite\Excel\Excel::HTML),
        };
    }

    /**
     * Import commodities data from Excel.
     */
    public function import(CommodityImportRequest $request)
    {
        $this->authorize('import barang');

        Excel::import(new CommoditiesImport, $request->file('file'));

        return to_route('barang.index')->with('success', 'Data barang berhasil diimpor!');
    }
}
