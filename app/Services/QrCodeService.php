<?php

namespace App\Services;

use Akira\QrCode\Facades\QrCode;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\HtmlString;

#[Singleton]
readonly class QrCodeService
{
    /**
     * Generate an inline SVG QR code for web and Livewire views.
     */
    public function forWeb(string $code, int $size = 200): HtmlString
    {
        $svg = (string) QrCode::format('svg')
            ->size($size)
            ->color(0, 0, 0, 100)
            ->generate($this->verificationUrl($code));

        return new HtmlString($svg);
    }

    /**
     * Generate a base64-encoded SVG image tag optimized for DomPDF rendering.
     */
    public function forPdf(string $code, int $size = 100): HtmlString
    {
        $svg = (string) QrCode::format('svg')
            ->size($size)
            ->color(0, 0, 0, 100)
            ->generate($this->verificationUrl($code));

        $base64 = base64_encode($svg);

        return new HtmlString(
            "<img src=\"data:image/svg+xml;base64,{$base64}\" width=\"{$size}\" height=\"{$size}\" alt=\"QR Code\" />"
        );
    }

    /**
     * Generate a high-resolution PNG binary string for file downloads.
     */
    public function forDownload(string $code, int $size = 300): string
    {
        return (string) QrCode::format('png')
            ->size($size)
            ->color(0, 0, 0, 100)
            ->generate($this->verificationUrl($code));
    }

    /**
     * Build the public verification URL for the given commodity code.
     */
    public function verificationUrl(string $code): string
    {
        return route('verifikasi.barang', $code);
    }
}
