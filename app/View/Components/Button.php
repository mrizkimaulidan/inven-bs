<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a styled button with an optional icon and label.
 */
class Button extends Component
{
    /**
     * List of supported Bootstrap button variants.
     *
     * @var list<string>
     */
    public const array VARIANTS = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
        'link',
    ];

    /**
     * List of supported native button types.
     *
     * @var list<string>
     */
    public const array TYPES = [
        'button',
        'submit',
        'reset',
    ];

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
        // Fall back to the default style when the requested variant is unsupported.
        if (! in_array($this->variant, self::VARIANTS, true)) {
            $this->variant = 'primary';
        }

        // Default to a non-submitting button when the requested type is unsupported.
        if (! in_array($this->type, self::TYPES, true)) {
            $this->type = 'button';
        }
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.button');
    }
}
