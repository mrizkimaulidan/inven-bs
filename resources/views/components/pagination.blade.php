@if ($shouldShow())
    <div class="{{ $wrapperClass() }}">
        <div class="text-muted mb-md-0 mb-2">{{ $getInfoText() }}</div>

        @if ($hasPages())
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                    {{-- Previous --}}
                    <li class="page-item {{ $onFirstPage() ? 'disabled' : '' }}">
                        <button
                            class="page-link"
                            wire:click="previousPage('page')"
                            wire:loading.attr="disabled"
                            {{ $onFirstPage() ? 'tabindex="-1"' : '' }}
                        >
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </li>

                    {{-- First Page --}}
                    @if ($shouldShowFirstPage())
                        <li class="page-item">
                            <button class="page-link" wire:click="gotoPage(1, 'page')">1</button>
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
                            <button class="page-link" wire:click="gotoPage({{ $page }}, 'page')">
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
                            <button class="page-link" wire:click="gotoPage({{ $lastPage() }}, 'page')">
                                {{ $lastPage() }}
                            </button>
                        </li>
                    @endif

                    {{-- Next --}}
                    <li class="page-item {{ $hasMorePages() ? '' : 'disabled' }}">
                        <button
                            class="page-link"
                            wire:click="nextPage('page')"
                            wire:loading.attr="disabled"
                            {{ $hasMorePages() ? '' : 'tabindex="-1"' }}
                        >
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
@endif
