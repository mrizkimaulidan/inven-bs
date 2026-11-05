<button
    type="button"
    @class([
        'dropdown-item has-icon text-danger' => $placement === 'dropdown',
        'btn btn-danger btn-lg btn-block btn-icon-split' => $placement === 'sidebar',
    ])
    wire:click="logout"
    wire:loading.attr="disabled"
    wire:target="logout"
>
    @if ($placement === 'sidebar')
        <i class="fas fa-right-from-bracket"></i>
    @else
        <i class="fas fa-sign-out-alt"></i>
    @endif
    Logout
</button>
