@php
    $qrMarkup = filled($qrcode ?? null) ? (string) $qrcode : null;
@endphp

<div>
    <x-modal title="Kode QR Barang">
        <x-slot:body>
            <div class="bg-light d-flex flex-column align-items-center justify-content-center rounded px-3 py-5">
                @if ($qrMarkup)
                    <div class="rounded border bg-white p-4 shadow-sm">
                        <div class="qrcode-media d-flex align-items-center justify-content-center">
                            {!! $qrMarkup !!}
                        </div>
                    </div>
                @else
                    <div class="text-muted small rounded border bg-white p-4 shadow-sm">Kode QR belum tersedia.</div>
                @endif

                <div class="d-inline-flex align-items-center rounded-pill d-print-none mt-4 border bg-white px-3 py-2 shadow-sm">
                    <i class="fas fa-qrcode text-primary mr-2" aria-hidden="true"></i>
                    <span class="small font-weight-bold text-dark">Kode QR Barang</span>
                </div>

                <p class="text-muted small d-print-none mt-3 mb-0 text-center">
                    <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>
                    Scan QR code untuk melihat detail barang
                </p>

                @if ($qrMarkup)
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
                            <i
                                class="fas fa-download mr-1"
                                aria-hidden="true"
                                wire:loading.remove
                                wire:target="download"
                            ></i>
                            <span wire:loading.remove wire:target="download">Unduh QR Code</span>
                            <span wire:loading wire:target="download">Mengunduh...</span>
                        </button>
                    </div>
                @endif
            </div>
        </x-slot:body>
    </x-modal>
</div>
