@if ($shouldShow())
    <div class="{{ $wrapperClasses() }}">
        <div class="text-muted mb-md-0 mb-2">{{ $getInfoText() }}</div>

        @if ($hasPages())
            <nav class="d-inline-block" aria-label="Pagination">
                <ul class="pagination mb-0">
                    {{-- Previous --}}
                    <li class="page-item {{ $onFirstPage() ? 'disabled' : '' }}">
                        <button
                            type="button"
                            class="page-link"
                            wire:click="previousPage('{{ $pageName }}')"
                            wire:loading.attr="disabled"
                            @disabled($onFirstPage())
                        >
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </li>

                    {{-- First Page --}}
                    @if ($shouldShowFirstPage())
                        <li class="page-item">
                            <button type="button" class="page-link" wire:click="gotoPage(1, '{{ $pageName }}')">
                                1
                            </button>
                        </li>
                        @if ($shouldShowEllipsisStart())
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($pageRange() as $page)
                        <li class="page-item {{ $page == $currentPage() ? 'active' : '' }}">
                            <button
                                type="button"
                                class="page-link"
                                wire:click="gotoPage({{ $page }}, '{{ $pageName }}')"
                                @if ($page == $currentPage())
                                    disabled
                                    aria-current="page"
                                @endif
                            >
                                {{ $page }}
                                @if ($page == $currentPage())
                                    <span class="sr-only">(current)</span>
                                @endif
                            </button>
                        </li>
                    @endforeach

                    {{-- Last Page --}}
                    @if ($shouldShowLastPage())
                        @if ($shouldShowEllipsisEnd())
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <button
                                type="button"
                                class="page-link"
                                wire:click="gotoPage({{ $lastPage() }}, '{{ $pageName }}')"
                            >
                                {{ $lastPage() }}
                            </button>
                        </li>
                    @endif

                    {{-- Next --}}
                    <li class="page-item {{ $hasMorePages() ? '' : 'disabled' }}">
                        <button
                            type="button"
                            class="page-link"
                            wire:click="nextPage('{{ $pageName }}')"
                            wire:loading.attr="disabled"
                            @disabled(! $hasMorePages())
                        >
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
@endif
