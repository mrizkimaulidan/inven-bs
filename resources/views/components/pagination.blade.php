@if ($shouldShow())
    @php
        $current = $currentPage();
        $last = $lastPage();
        $isFirst = $onFirstPage();
        $hasMore = $hasMorePages();
        $resolvedPageName = trim($pageName) !== '' ? trim($pageName) : 'page';
    @endphp

    <div class="{{ $wrapperClasses() }}">
        <div class="text-muted mb-md-0 mb-2">{{ $getInfoText() }}</div>

        @if ($hasPages())
            <nav class="d-inline-block" aria-label="Navigasi halaman">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $isFirst ? 'disabled' : '' }}">
                        <button
                            type="button"
                            class="page-link"
                            aria-label="Halaman sebelumnya"
                            wire:click="previousPage('{{ $resolvedPageName }}')"
                            wire:loading.attr="disabled"
                            @disabled($isFirst)
                        >
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        </button>
                    </li>

                    @if ($shouldShowFirstPage())
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                aria-label="Ke halaman 1"
                                wire:click="gotoPage(1, '{{ $resolvedPageName }}')"
                            >
                                1
                            </button>
                        </li>

                        @if ($shouldShowEllipsisStart())
                            <li class="page-item disabled" aria-hidden="true">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif

                    @foreach ($pageRange() as $page)
                        @php
                            $pageNumber = (int) $page;
                            $isCurrent = $pageNumber === $current;
                        @endphp

                        <li class="page-item {{ $isCurrent ? 'active' : '' }}">
                            <button
                                type="button"
                                class="page-link"
                                aria-label="Halaman {{ $pageNumber }}"
                                wire:click="gotoPage({{ $pageNumber }}, '{{ $resolvedPageName }}')"
                                @if ($isCurrent)
                                    disabled
                                    aria-current="page"
                                @endif
                            >
                                {{ $pageNumber }}
                                @if ($isCurrent)
                                    <span class="sr-only">(halaman saat ini)</span>
                                @endif
                            </button>
                        </li>
                    @endforeach

                    @if ($shouldShowLastPage())
                        @if ($shouldShowEllipsisEnd())
                            <li class="page-item disabled" aria-hidden="true">
                                <span class="page-link">...</span>
                            </li>
                        @endif

                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                aria-label="Ke halaman {{ $last }}"
                                wire:click="gotoPage({{ $last }}, '{{ $resolvedPageName }}')"
                            >
                                {{ $last }}
                            </button>
                        </li>
                    @endif

                    <li class="page-item {{ $hasMore ? '' : 'disabled' }}">
                        <button
                            type="button"
                            class="page-link"
                            aria-label="Halaman berikutnya"
                            wire:click="nextPage('{{ $resolvedPageName }}')"
                            wire:loading.attr="disabled"
                            @disabled(! $hasMore)
                        >
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
@endif
