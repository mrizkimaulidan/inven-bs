<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a modal shell with optional Livewire submit and close actions.
 */
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
     * @return void
     */
    public function __construct(
        public string $title,
        public ?string $submit = null,
        public string $size = 'md',
        public bool $scrollable = false,
        public ?string $id = null,
    ) {
        /**
         * Fall back to the default size when the requested size is unsupported.
         */ if (! in_array($this->size, self::SIZES, true)) {
            $this->size = 'md';
        }
    }

    /**
     * Get the resolved DOM id for the modal element.
     *
     * @return string
     */
    public function modalId(): string
    {
        return $this->id ?? 'modal-'.uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
