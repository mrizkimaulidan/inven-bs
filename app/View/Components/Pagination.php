<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

/**
 * Build page navigation links and display the current paginator range.
 */
class Pagination extends Component
{
    /**
     * Number of pages shown around the current page.
     */
    public const WINDOW = 1;

    /**
     * Create a new component instance.
     *
     * @param  LengthAwarePaginator  $paginator  The paginator instance.
     * @param  string|null  $infoText  The custom info text template.
     * @param  string|null  $wrapperCss  The custom wrapper CSS class.
     * @param  string  $pageName  The paginator page name.
     * @return void
     */
    public function __construct(
        public readonly LengthAwarePaginator $paginator,
        public readonly ?string $infoText = null,
        public readonly ?string $wrapperCss = null,
        public readonly string $pageName = 'page',
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.pagination');
    }

    /**
     * Get the formatted pagination info text.
     *
     * @return string
     */
    public function getInfoText(): string
    {
        $firstItem = $this->paginator->firstItem() ?? 0;
        $lastItem = $this->paginator->lastItem() ?? 0;
        $totalItems = $this->paginator->total();

        $infoText = $this->infoText ?? $this->getDefaultInfoText();

        return str_replace(
            [':start', ':end', ':total'],
            [$firstItem, $lastItem, $totalItems],
            $infoText
        );
    }

    /**
     * Get the default info text based on the current locale.
     *
     * @return string
     */
    private function getDefaultInfoText(): string
    {
        return match (app()->getLocale()) {
            'id' => 'Menampilkan :start - :end dari :total data',
            'en' => 'Showing :start to :end of :total data',
            default => 'Showing :start to :end of :total data',
        };
    }

    /**
     * Determine if pagination should be shown.
     *
     * @return bool
     */
    public function shouldShow(): bool
    {
        return $this->paginator->total() > 0;
    }

    /**
     * Determine if pagination has more than one page.
     *
     * @return bool
     */
    public function hasPages(): bool
    {
        return $this->paginator->lastPage() > 1;
    }

    /**
     * Get the current page number.
     *
     * @return int
     */
    public function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page number.
     *
     * @return int
     */
    public function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * Determine if the current page is the first page.
     *
     * @return bool
     */
    public function onFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    /**
     * Determine if there are more pages to display.
     *
     * @return bool
     */
    public function hasMorePages(): bool
    {
        return $this->paginator->hasMorePages();
    }

    /**
     * Get the start page number for pagination links.
     *
     * @return int
     */
    public function startPage(): int
    {
        $currentPage = $this->currentPage();
        $lastPage = $this->lastPage();

        if ($lastPage <= 3) {
            return 1;
        }

        if ($currentPage <= 2) {
            return 1;
        }

        if ($currentPage >= $lastPage - 1) {
            return max(1, $lastPage - 2);
        }

        return max(1, $currentPage - self::WINDOW);
    }

    /**
     * Get the end page number for pagination links.
     *
     * @return int
     */
    public function endPage(): int
    {
        $currentPage = $this->currentPage();
        $lastPage = $this->lastPage();

        if ($lastPage <= 3) {
            return $lastPage;
        }

        if ($currentPage <= 2) {
            return min(3, $lastPage);
        }

        if ($currentPage >= $lastPage - 1) {
            return $lastPage;
        }

        return min($lastPage, $currentPage + self::WINDOW);
    }

    /**
     * Determine if the first page link should be shown.
     *
     * @return bool
     */
    public function shouldShowFirstPage(): bool
    {
        return $this->startPage() > 1;
    }

    /**
     * Determine if the start ellipsis should be shown.
     *
     * @return bool
     */
    public function shouldShowEllipsisStart(): bool
    {
        return $this->startPage() > 2;
    }

    /**
     * Determine if the end ellipsis should be shown.
     *
     * @return bool
     */
    public function shouldShowEllipsisEnd(): bool
    {
        return $this->endPage() < $this->lastPage() - 1;
    }

    /**
     * Determine if the last page link should be shown.
     *
     * @return bool
     */
    public function shouldShowLastPage(): bool
    {
        return $this->endPage() < $this->lastPage();
    }

    /**
     * Get the range of page numbers to display.
     *
     * @return array<int, int>
     */
    public function pageRange(): array
    {
        $startPage = $this->startPage();
        $endPage = $this->endPage();

        /**
         * Return no page links when the calculated range is invalid.
         */ if ($startPage > $endPage) {
            return [];
        }

        return range($startPage, $endPage);
    }

    /**
     * Build the CSS classes for the pagination wrapper.
     *
     * @return string
     */
    public function wrapperClasses(): string
    {
        return $this->wrapperCss ?? 'card-footer d-flex justify-content-between align-items-center flex-wrap';
    }
}
