<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatisticCard extends Component
{
    /**
     * List of supported Bootstrap background colors.
     */
    public const COLORS = [
        'primary', 'secondary', 'success', 'danger',
        'warning', 'info', 'light', 'dark',
    ];

    /**
     * Create a new component instance.
     *
     * @param  string  $icon  The Font Awesome icon class (without the "fas" prefix).
     * @param  string  $title  The statistic card title.
     * @param  string  $bgColor  The Bootstrap background color class.
     * @param  string|int|float  $value  The statistic value.
     */
    public function __construct(
        public string $icon,
        public string $title,
        public string $bgColor = 'primary',
        public string|int|float $value = 0,
    ) {
        // Ensure the background color is valid, otherwise fall back to "primary".
        if (! in_array($this->bgColor, self::COLORS, true)) {
            $this->bgColor = 'primary';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.statistic-card');
    }
}
