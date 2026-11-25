<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a dashboard statistic with its title, value, and icon.
 */
class StatisticCard extends Component
{
    /**
     * List of supported Bootstrap background colors.
     *
     * @var list<string>
     */
    public const array COLORS = [
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
        $trimmedIcon = trim($this->icon);
        $this->icon = $trimmedIcon !== '' ? $trimmedIcon : 'fa-chart-bar';

        // Fall back to the default color when the requested color is unsupported.
        if (! in_array($this->bgColor, self::COLORS, true)) {
            $this->bgColor = 'primary';
        }
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.statistic-card');
    }
}
