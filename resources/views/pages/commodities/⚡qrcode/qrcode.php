<?php

use Akira\QrCode\Facades\QrCode;
use Livewire\Component;

/**
 * Generate a QR code that links to the commodity verification page.
 */
new class extends Component
{
    /**
     * The generated QR code image.
     */
    public ?string $qrcode = null;

    /**
     * Generate an SVG QR code for the commodity verification URL.
     *
     * @param  ?string  $qrcode
     * @return void
     */
    public function mount(?string $qrcode): void
    {
        $url = route('verifikasi.barang', $qrcode);

        $this->qrcode = QrCode::format('svg')
            ->color(0, 0, 0, 100)
            ->generate($url);
    }
};
