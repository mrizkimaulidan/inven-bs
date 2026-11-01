<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a reusable form input.
 */
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
     * @param  string|null  $selectedFileName  The selected file name for file inputs.
     * @return void
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public bool $required = false,
        public ?string $icon = null,
        public ?string $help = null,
        public string $type = 'text',
        public ?string $selectedFileName = null,
    ) {
        /**
         * Fall back to text when the requested input type is unsupported.
         */ if (! in_array($this->type, self::TYPES, true)) {
            $this->type = 'text';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
