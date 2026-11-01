<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a compact label with optional icon and status styling.
 */
class Badge extends Component
{
    /**
     * List of supported Bootstrap badge variants.
     */
    public const VARIANTS = [
        'primary', 'secondary', 'success', 'danger',
        'warning', 'info', 'light', 'dark',
    ];

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The badge text content.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  string  $variant  The Bootstrap badge variant.
     * @param  bool  $pill  Whether to render the badge as a pill.
     * @return void
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
        public string $variant = 'primary',
        public bool $pill = false,
    ) {
        /**
         * Fall back to the default style when the requested variant is unsupported.
         */ if (! in_array($this->variant, self::VARIANTS, true)) {
            $this->variant = 'primary';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }
}
