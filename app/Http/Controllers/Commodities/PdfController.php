<?php

namespace App\Http\Controllers\Commodities;

use PDF;
use App\Commodity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $commodities = Commodity::all();
        $pdf = PDF::loadView('commodities.pdf', compact('commodities'))->setPaper('a4');

        return $pdf->stream('print.pdf');
    }
}
