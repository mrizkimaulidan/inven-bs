<?php

use Akira\QrCode\Facades\QrCode;
use Livewire\Component;

new class extends Component
{
    /**
     * The generated QR code image.
     */
    public ?string $qrcode = null;

    /**
     * Mount the component.
     */
    public function mount(?string $qrcode): void
    {
        $url = route('verifikasi.barang', $qrcode);

        $this->qrcode = QrCode::format('svg')->generate($url);
    }
};
