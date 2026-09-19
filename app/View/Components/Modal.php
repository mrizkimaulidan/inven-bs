<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $title  The title displayed in the modal header.
     * @param  string|null  $submit  Livewire method name for wire:submit (null = no form).
     * @param  string  $size  Modal size: sm, md, lg, xl.
     */
    public function __construct(
        public string $title,
        public ?string $submit = null,
        public string $size = 'md',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
