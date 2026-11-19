<div>
    <x-modal title="Kode QR Barang">
        <x-slot:body>
            <div class="bg-light d-flex flex-column align-items-center justify-content-center rounded px-3 py-5">
                {{-- QR code image --}}
                <div class="rounded border bg-white p-4 shadow-sm">
                    <div class="qrcode-media d-flex align-items-center justify-content-center">{!! $qrcode !!}</div>
                </div>

                {{-- QR code label --}}
                <div class="d-inline-flex align-items-center rounded-pill d-print-none mt-4 border bg-white px-3 py-2 shadow-sm">
                    <i class="fas fa-qrcode text-primary mr-2"></i>
                    <span class="small font-weight-bold text-dark">Kode QR Barang</span>
                </div>

                {{-- Scan instructions --}}
                <p class="text-muted small d-print-none mt-3 mb-0 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Scan QR code untuk melihat detail barang
                </p>

                {{-- Download button (Stisla + Bootstrap 4.6.2) --}}
                @if ($qrcode)
                    <div class="d-print-none mt-4">
                        <button
                            type="button"
                            class="btn btn-icon icon-left btn-primary px-4"
                            wire:click="download"
                            wire:loading.attr="disabled"
                            wire:target="download"
                        >
                            <span
                                class="spinner-border spinner-border-sm mr-2"
                                role="status"
                                aria-hidden="true"
                                wire:loading
                                wire:target="download"
                            ></span>
                            <i class="fas fa-download" wire:loading.remove wire:target="download"></i>
                            <span wire:loading.remove wire:target="download">Unduh QR Code</span>
                            <span wire:loading wire:target="download">Mengunduh...</span>
                        </button>
                    </div>
                @endif
            </div>
        </x-slot:body>
    </x-modal>
</div>
