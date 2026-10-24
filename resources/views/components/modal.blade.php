{{-- Modal shell. Visibility is controlled by the parent Livewire component. --}}
<div
    class="modal fade show d-block"
    id="{{ $modalId() }}"
    tabindex="-1"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $modalId() }}-title"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    data-backdrop="static"
>
    <div class="modal-dialog modal-{{ $size }} @if ($scrollable) modal-dialog-scrollable @endif" role="document">
        <div class="modal-content">
            @if ($submit)
                <form wire:submit="{{ $submit }}">
            @endif

            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId() }}-title">{{ $title }}</h5>
                <button wire:click="$dispatch('closeModal')" type="button" class="close" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">{{ $body }}</div>

            {{-- Footer --}}
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
