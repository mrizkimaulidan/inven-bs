<div>
    <x-modal title="QR Code Barang">
        <x-slot:body>
            <div class="qrcode-preview d-flex flex-column align-items-center justify-content-center px-3 py-5">
                {{-- Preview Card --}}
                <div class="qrcode-preview__card rounded bg-white p-4 shadow-sm">
                    <div class="qrcode-preview__media d-flex align-items-center justify-content-center">
                        {!! $qrcode !!}
                    </div>
                </div>

                {{-- Info Chip --}}
                <div class="qrcode-preview__chip d-inline-flex align-items-center rounded-pill mt-4 border bg-white px-3 py-2 shadow-sm">
                    <i class="fas fa-qrcode text-muted mr-2"></i>
                    <span class="small font-weight-bold text-dark">QR Code Barang</span>
                </div>

                {{-- Helper Text --}}
                <p class="qrcode-preview__hint text-muted small mt-3 mb-0 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Scan QR code untuk melihat detail barang
                </p>
            </div>
        </x-slot:body>
    </x-modal>
</div>
