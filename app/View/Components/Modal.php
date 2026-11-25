<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a modal shell with optional Livewire submit and close actions.
 */
class Modal extends Component
{
    /**
     * List of supported modal sizes.
     *
     * @var list<string>
     */
    public const array SIZES = ['sm', 'md', 'lg', 'xl'];

    /**
     * Cached fallback DOM identifier when no explicit ID is supplied.
     */
    private ?string $generatedId = null;

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
        // Fall back to the default size when the requested size is unsupported.
        if (! in_array($this->size, self::SIZES, true)) {
            $this->size = 'md';
        }
    }

    /**
     * Get the resolved DOM id for the modal element.
     */
    public function modalId(): string
    {
        if (is_string($this->id) && trim($this->id) !== '') {
            return trim($this->id);
        }

        $this->generatedId ??= 'modal-'.uniqid();

        return $this->generatedId;
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.modal');
    }
}
