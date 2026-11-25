@php
    $resolvedPlacement = is_string($placement ?? null) ? trim($placement) : 'dropdown';
    if (! in_array($resolvedPlacement, ['dropdown', 'sidebar'], true)) {
        $resolvedPlacement = 'dropdown';
    }

    $isSidebar = $resolvedPlacement === 'sidebar';
@endphp

<button
    type="button"
    @class([
        'dropdown-item has-icon text-danger' => ! $isSidebar,
        'btn btn-danger btn-lg btn-block btn-icon-split' => $isSidebar,
    ])
    wire:click="logout"
    wire:loading.attr="disabled"
    wire:target="logout"
>
    @if ($isSidebar)
        <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
        <span>Keluar</span>
    @else
        <i class="fas fa-sign-out-alt mr-1" aria-hidden="true"></i>
        <span>Keluar</span>
    @endif
</button>
