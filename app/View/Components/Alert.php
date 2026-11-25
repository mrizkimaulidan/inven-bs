<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render available session notifications with their configured icons and styles.
 */
class Alert extends Component
{
    /**
     * Mapping of session flash keys to their display configuration.
     *
     * Each entry defines the alert title and Font Awesome icon
     * used when the corresponding session key is present.
     *
     * @var array<string, array{title: string, icon: string}>
     */
    public const array ALERT_TYPES = [
        'success' => ['title' => 'Berhasil!',   'icon' => 'fa-check-circle'],
        'danger' => ['title' => 'Gagal!',      'icon' => 'fa-exclamation-circle'],
        'warning' => ['title' => 'Peringatan!', 'icon' => 'fa-exclamation-triangle'],
        'info' => ['title' => 'Informasi!',  'icon' => 'fa-info-circle'],
    ];

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.alert', [
            'alertTypes' => self::ALERT_TYPES,
        ]);
    }
}
