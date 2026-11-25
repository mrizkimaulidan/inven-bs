@php
    $resolvedModalId = $modalId();
    $submitMethod = is_string($submit) ? trim($submit) : '';
@endphp

<div
    class="modal fade show d-block"
    id="{{ $resolvedModalId }}"
    tabindex="-1"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $resolvedModalId }}-title"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    data-backdrop="static"
>
    <div class="modal-dialog modal-{{ $size }} @if ($scrollable) modal-dialog-scrollable @endif" role="document">
        <div class="modal-content">
            @if ($submitMethod !== '')
                <form wire:submit.prevent="{{ $submitMethod }}">
            @endif

            <div class="modal-header">
                <h5 class="modal-title" id="{{ $resolvedModalId }}-title">{{ $title }}</h5>
                <button wire:click="$dispatch('closeModal')" type="button" class="close" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">{{ $body ?? '' }}</div>

            <div class="modal-footer bg-whitesmoke br">
                <button wire:click="$dispatch('closeModal')" type="button" class="btn btn-secondary">Tutup</button>

                {{ $footer ?? '' }}
            </div>

            @if ($submitMethod !== '')
                </form>
            @endif
        </div>
    </div>
</div>
