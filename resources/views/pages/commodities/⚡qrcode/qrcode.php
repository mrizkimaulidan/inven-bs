<?php

use App\Services\QrCodeService;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Generate and preview a QR code that links to the commodity verification page.
 */
new class extends Component
{
    /**
     * The commodity verification code.
     */
    public ?string $code = null;

    /**
     * The generated SVG markup for preview.
     */
    public ?string $qrcode = null;

    /**
     * Generate an SVG QR code for the commodity verification URL.
     */
    public function mount(?string $qrcode, QrCodeService $qrCodeService): void
    {
        if (blank($qrcode)) {
            return;
        }

        $this->code = trim($qrcode);
        $this->qrcode = $qrCodeService->forWeb($this->code)->toHtml();
    }

    /**
     * Stream the QR code as a downloadable PNG file.
     */
    public function download(QrCodeService $qrCodeService): ?StreamedResponse
    {
        if (blank($this->code)) {
            return null;
        }

        $code = $this->code;
        $safeFilename = 'qrcode-'.Str::slug($code).'.png';

        return response()->streamDownload(
            static function () use ($qrCodeService, $code): void {
                echo $qrCodeService->forDownload($code);
            },
            $safeFilename !== 'qrcode-.png' ? $safeFilename : 'qrcode.png',
            ['Content-Type' => 'image/png'],
        );
    }
};
