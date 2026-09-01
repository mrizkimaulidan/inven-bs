<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Indicates whether the button has an icon.
     */
    public bool $hasIcon;

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The button text
     * @param  string|null  $icon  The Font Awesome icon class (e.g., 'fa-file-export')
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
    ) {
        $this->hasIcon = ! is_null($icon);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }
}
