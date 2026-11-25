<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a compact label with optional icon and status styling.
 */
class Badge extends Component
{
    /**
     * List of supported Bootstrap badge variants.
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
    ];

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The badge text content.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  string  $variant  The Bootstrap badge variant.
     * @param  bool  $pill  Whether to render the badge as a pill.
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
        public string $variant = 'primary',
        public bool $pill = false,
    ) {
        // Fall back to the default style when the requested variant is unsupported.
        if (! in_array($this->variant, self::VARIANTS, true)) {
            $this->variant = 'primary';
        }
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.badge');
    }
}
