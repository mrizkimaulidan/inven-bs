<?php

namespace App\Http\Controllers;

use Akira\QrCode\Facades\QrCode;
use App\Models\Commodity;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class CommodityController extends Controller
{
    /**
     * Generate and download a PDF document.
     *
     * @param  Commodity  $commodity
     * @return Response
     */
    public function generatePdf(Commodity $commodity): Response
    {
        $url = route('verifikasi.barang', $commodity->qr_code);

        $qrCode = QrCode::format('png')->size(120)->generate($url);

        return Pdf::loadView('commodities.pdf', compact('commodity', 'qrCode'))
            ->setPaper('a4')
            ->stream("{$commodity->item_code}.pdf");
    }
}
