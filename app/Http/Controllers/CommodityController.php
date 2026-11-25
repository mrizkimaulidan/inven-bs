<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle PDF generation actions for commodity records.
 */
class CommodityController extends Controller
{
    public function __construct(
        private readonly QrCodeService $qrCodeService,
    ) {}

    /**
     * Generate and stream a PDF document for a single commodity.
     */
    public function generatePdf(Commodity $commodity): Response
    {
        $qrCode = $this->qrCodeService->forPdf($commodity->qr_code);

        return Pdf::loadView('commodities.pdf', compact('commodity', 'qrCode'))
            ->setPaper('a4')
            ->stream("{$commodity->item_code}.pdf");
    }

    /**
     * Generate and stream a PDF document for all commodities.
     */
    public function generateAllPdf(): Response
    {
        $commodities = Commodity::query()
            ->with('commodityFundingSource')
            ->get();

        $qrCodes = [];

        foreach ($commodities as $commodity) {
            $qrCodes[$commodity->id] = blank($commodity->qr_code)
                ? null
                : $this->qrCodeService->forPdf($commodity->qr_code);
        }

        return Pdf::loadView('commodities.pdf-multiple', compact('commodities', 'qrCodes'))
            ->setPaper('a4')
            ->stream('barang.pdf');
    }
}
