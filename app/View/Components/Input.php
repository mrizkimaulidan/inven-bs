<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * List of supported input types.
     */
    public const TYPES = [
        'text', 'email', 'password', 'number', 'tel',
        'url', 'search', 'date', 'datetime-local',
        'time', 'month', 'week', 'color', 'file',
    ];

    /**
     * Create a new component instance.
     *
     * @param  string  $name  The input name attribute.
     * @param  string|null  $label  The input label.
     * @param  bool  $required  Indicates whether the input is required.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  string|null  $help  The help text.
     * @param  string  $type  The native input type.
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public bool $required = false,
        public ?string $icon = null,
        public ?string $help = null,
        public string $type = 'text',
    ) {
        // Ensure the input type is valid, otherwise fall back to "text".
        if (! in_array($this->type, self::TYPES, true)) {
            $this->type = 'text';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
