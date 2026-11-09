<?php

namespace App\Http\Controllers;

use Akira\QrCode\Facades\QrCode;
use App\Models\Commodity;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class CommodityController extends Controller
{
    /**
     * Generate and download a PDF document for a single commodity.
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

    /**
     * Generate and download a PDF document for all commodities.
     *
     * @return Response
     */
    public function generateAllPdf(): Response
    {
        $commodities = Commodity::with('commodityFundingSource')->get();

        $qrCodes = [];
        foreach ($commodities as $commodity) {
            if (is_null($commodity->qr_code) || $commodity->qr_code === '') {
                $qrCodes[$commodity->id] = null;

                continue;
            }

            $url = route('verifikasi.barang', $commodity->qr_code);
            $qrCodes[$commodity->id] = QrCode::format('png')->size(120)->generate($url);
        }

        return Pdf::loadView('commodities.pdf-multiple', compact('commodities', 'qrCodes'))
            ->setPaper('a4')
            ->stream('barang.pdf');
    }
}
