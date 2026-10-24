<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * List of supported modal sizes.
     */
    public const SIZES = ['sm', 'md', 'lg', 'xl'];

    /**
     * Create a new component instance.
     *
     * @param  string  $title  The title displayed in the modal header.
     * @param  string|null  $submit  Livewire method name for wire:submit (null = no form).
     * @param  string  $size  Modal size: sm, md, lg, xl.
     * @param  bool  $scrollable  Whether the modal body is scrollable.
     * @param  string|null  $id  Optional DOM id for the modal element.
     */
    public function __construct(
        public string $title,
        public ?string $submit = null,
        public string $size = 'md',
        public bool $scrollable = false,
        public ?string $id = null,
    ) {
        // Ensure the modal size is valid, otherwise fall back to "md".
        if (! in_array($this->size, self::SIZES, true)) {
            $this->size = 'md';
        }
    }

    /**
     * Get the resolved DOM id for the modal element.
     */
    public function modalId(): string
    {
        return $this->id ?? 'modal-'.uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
