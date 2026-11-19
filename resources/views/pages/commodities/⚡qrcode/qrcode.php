

<?php

use App\Services\QrCodeService;
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

        $this->code = $qrcode;
        $this->qrcode = $qrCodeService->forWeb($qrcode)->toHtml();
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

        return response()->streamDownload(
            static function () use ($qrCodeService, $code): void {
                echo $qrCodeService->forDownload($code);
            },
            "qrcode-{$code}.png",
            ['Content-Type' => 'image/png'],
        );
    }
};
