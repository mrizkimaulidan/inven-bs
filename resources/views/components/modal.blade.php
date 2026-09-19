<div>
    <div
        class="modal fade show d-block"
        tabindex="-1"
        role="dialog"
        style="display: block; background: rgba(0, 0, 0, 0.5)"
        data-backdrop="static"
    >
        <div class="modal-dialog modal-{{ $size }}" role="document">
            <div class="modal-content">
                @if ($submit)
                    <form wire:submit="{{ $submit }}">
                @endif

                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button wire:click="$dispatch('closeModal')" type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">{{ $body ?? '' }}</div>

                <div class="modal-footer bg-whitesmoke br">
                    <button wire:click="$dispatch('closeModal')" type="button" class="btn btn-secondary">Tutup</button>

                    {{ $footer ?? '' }}
                </div>

                @if ($submit)
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
