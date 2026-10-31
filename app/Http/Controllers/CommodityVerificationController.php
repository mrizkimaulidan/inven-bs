<?php

namespace App\Http\Controllers;

use App\Enums\CommodityCondition;
use App\Models\Commodity;

class CommodityVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $qrcode)
    {
        $commodity = Commodity::with([
            'brand',
            'material',
            'commodityLocation',
            'commodityFundingSource',
        ])->firstWhere('qr_code', $qrcode);

        if (! $commodity) {
            return response()->view('verifications.404', [
                'icon' => 'fa-qrcode',
                'color' => 'danger',
                'title' => 'Barang Tidak Ditemukan',
                'message' => 'Kode QR yang Anda scan tidak terdaftar dalam sistem inventaris. Pastikan QR code dalam kondisi baik dan benar.',
                'backUrl' => url('/'),
                'backIcon' => 'fa-home',
                'backLabel' => 'Kembali ke Beranda',
            ], 404);
        }

        $conditionStyle = $this->conditionStyle($commodity->condition);

        return view('verifications.commodity', compact('commodity', 'conditionStyle'));
    }

    /**
     * Resolve the icon and badge styling for the given condition.
     */
    private function conditionStyle(CommodityCondition $condition): array
    {
        return match ($condition) {
            CommodityCondition::GOOD => [
                'icon' => 'fa-check-circle',
                'badge' => 'badge-success',
            ],
            CommodityCondition::POOR => [
                'icon' => 'fa-exclamation-circle',
                'badge' => 'badge-warning',
            ],
            CommodityCondition::HEAVILY_DAMAGED => [
                'icon' => 'fa-circle-xmark',
                'badge' => 'badge-danger',
            ],
            default => [
                'icon' => 'fa-question-circle',
                'badge' => 'badge-secondary',
                'label' => 'Tidak Diketahui',
            ],
        };
    }
}
