<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a reusable form input with label, help text, and validation feedback.
 */
class Input extends Component
{
    /**
     * List of supported native input types.
     *
     * @var list<string>
     */
    public const array TYPES = [
        'text',
        'email',
        'password',
        'number',
        'tel',
        'url',
        'search',
        'date',
        'datetime-local',
        'time',
        'month',
        'week',
        'color',
        'file',
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
        // Fall back to text when the requested input type is unsupported.
        if (! in_array($this->type, self::TYPES, true)) {
            $this->type = 'text';
        }
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.input');
    }
}
