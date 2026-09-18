<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  LengthAwarePaginator  $paginator  The paginator instance
     * @param  string|null  $infoText  The custom info text template
     * @param  string|null  $wrapperClass  The custom wrapper CSS class
     */
    public function __construct(
        public readonly LengthAwarePaginator $paginator,
        public readonly ?string $infoText = null,
        public readonly ?string $wrapperClass = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pagination');
    }

    /**
     * Get the formatted pagination info text.
     */
    public function getInfoText(): string
    {
        $start = $this->paginator->firstItem() ?? 0;
        $end = $this->paginator->lastItem() ?? 0;
        $total = $this->paginator->total();

        $text = $this->infoText ?? $this->getDefaultInfoText();

        return str_replace(
            [':start', ':end', ':total'],
            [$start, $end, $total],
            $text
        );
    }

    /**
     * Get the default info text based on the current locale.
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
     */
    public function shouldShow(): bool
    {
        return $this->paginator->total() > 0;
    }

    /**
     * Determine if pagination has more than one page.
     */
    public function hasPages(): bool
    {
        return $this->paginator->lastPage() > 1;
    }

    /**
     * Get the current page number.
     */
    public function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page number.
     */
    public function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * Determine if the current page is the first page.
     */
    public function onFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    /**
     * Determine if there are more pages to display.
     */
    public function hasMorePages(): bool
    {
        return $this->paginator->hasMorePages();
    }

    /**
     * Get the start page number for pagination links.
     */
    public function startPage(): int
    {
        return once(function () {
            $current = $this->currentPage();
            $last = $this->lastPage();

            if ($last <= 3) {
                return 1;
            }

            $start = max(1, $current - 1);

            if ($current <= 2) {
                return 1;
            }

            if ($current >= $last - 1) {
                return max(1, $last - 2);
            }

            return $start;
        });
    }

    /**
     * Get the end page number for pagination links.
     */
    public function endPage(): int
    {
        return once(function () {
            $current = $this->currentPage();
            $last = $this->lastPage();

            if ($last <= 3) {
                return $last;
            }

            $end = min($last, $current + 1);

            if ($current <= 2) {
                return min(3, $last);
            }

            if ($current >= $last - 1) {
                return $last;
            }

            return $end;
        });
    }

    /**
     * Determine if the first page link should be shown.
     */
    public function shouldShowFirstPage(): bool
    {
        return $this->startPage() > 1;
    }

    /**
     * Determine if the start ellipsis should be shown.
     */
    public function shouldShowEllipsisStart(): bool
    {
        return $this->startPage() > 2;
    }

    /**
     * Determine if the end ellipsis should be shown.
     */
    public function shouldShowEllipsisEnd(): bool
    {
        return $this->endPage() < $this->lastPage() - 1;
    }

    /**
     * Determine if the last page link should be shown.
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
        return range($this->startPage(), $this->endPage());
    }

    /**
     * Get the wrapper class for the component.
     */
    public function wrapperClass(): string
    {
        return $this->wrapperClass ?? 'card-footer d-flex justify-content-between align-items-center flex-wrap';
    }
}
