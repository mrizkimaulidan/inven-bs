<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * List of supported Bootstrap button variants.
     */
    public const VARIANTS = [
        'primary', 'secondary', 'success', 'danger',
        'warning', 'info', 'light', 'dark', 'link',
    ];

    /**
     * List of supported native button types.
     */
    public const TYPES = ['button', 'submit', 'reset'];

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The button text content.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  string  $variant  The Bootstrap button variant.
     * @param  string  $type  The native button type.
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
        public string $variant = 'primary',
        public string $type = 'button',
    ) {
        // Ensure the variant is valid, otherwise fall back to the default.
        if (! in_array($this->variant, self::VARIANTS, true)) {
            $this->variant = 'primary';
        }

        // Ensure the button type is valid, otherwise default to "button"
        // to avoid unintended form submissions.
        if (! in_array($this->type, self::TYPES, true)) {
            $this->type = 'button';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
