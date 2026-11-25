<?php

declare(strict_types=1);

namespace App\Services;

use Akira\QrCode\Facades\QrCode;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\HtmlString;

/**
 * Generate commodity verification QR codes in SVG, base64 image, and PNG formats.
 */
#[Singleton]
readonly class QrCodeService
{
    /**
     * Generate an inline SVG QR code for web and Livewire views.
     */
    public function forWeb(string $code, int $size = 200): HtmlString
    {
        $svg = $this->renderQrCode('svg', $code, $size);

        return new HtmlString($svg);
    }

    /**
     * Generate a base64-encoded SVG image tag optimized for PDF rendering.
     */
    public function forPdf(string $code, int $size = 100): HtmlString
    {
        $svg = $this->renderQrCode('svg', $code, $size);
        $base64 = base64_encode($svg);

        return new HtmlString(
            sprintf(
                '<img src="data:image/svg+xml;base64,%s" width="%d" height="%d" alt="QR Code" />',
                $base64,
                $size,
                $size,
            ),
        );
    }

    /**
     * Generate a high-resolution PNG binary string for file downloads.
     */
    public function forDownload(string $code, int $size = 300): string
    {
        return $this->renderQrCode('png', $code, $size);
    }

    /**
     * Build the public verification URL for the given commodity code.
     */
    public function verificationUrl(string $code): string
    {
        return route('verifikasi.barang', trim($code));
    }

    /**
     * Render a QR code payload in the requested output format.
     */
    private function renderQrCode(string $format, string $code, int $size): string
    {
        return (string) QrCode::format($format)
            ->size($size)
            ->color(0, 0, 0, 100)
            ->generate($this->verificationUrl($code));
    }
}
