@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center">
            <!-- Mobile view -->
            <div class="flex justify-between w-full sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-neutral-400 bg-white border border-neutral-200 cursor-default rounded-full shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-neutral-700 bg-white border border-neutral-200 leading-5 rounded-full shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-50 active:text-red-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-red-400 dark:hover:border-red-800 dark:focus:ring-red-700">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-neutral-700 bg-white border border-neutral-200 leading-5 rounded-full shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-50 active:text-red-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-red-400 dark:hover:border-red-800 dark:focus:ring-red-700">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-neutral-400 bg-white border border-neutral-200 cursor-default leading-5 rounded-full shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <!-- Desktop pagination - centered -->
            <div class="hidden sm:flex sm:justify-center w-full">
                <span class="relative z-0 flex justify-center w-full space-x-1">
                    {{-- Previous Page Link --}}
                    @if (!$paginator->onFirstPage())
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" class="relative inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-neutral-600 bg-white border border-neutral-200 rounded-full leading-5 shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-50 active:text-red-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-red-400 dark:hover:border-red-800 dark:focus:ring-red-700" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-neutral-500 bg-white border border-neutral-200 cursor-default rounded-full leading-5 shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-red-500 border border-red-500 cursor-default rounded-full leading-5 shadow-md dark:bg-red-600 dark:border-red-600">{{ $page }}</span>
                                        </span>
                                    @else
                                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="relative inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-full leading-5 shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-50 active:text-red-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-300 dark:hover:border-red-800 dark:focus:ring-red-700" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </button>
                                    @endif
                                </span>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" class="relative inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-neutral-600 bg-white border border-neutral-200 rounded-full leading-5 shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-50 active:text-red-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-red-400 dark:hover:border-red-800 dark:focus:ring-red-700" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                </span>
            </div>

            <!-- Info text - centered on all screens -->
            <div class="w-full flex justify-center mt-4">
                <p class="text-sm text-neutral-700 leading-5 dark:text-neutral-400">
                    <span>{!! __('Showing') !!}</span>
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    <span>{!! __('to') !!}</span>
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    <span>{!! __('of') !!}</span>
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    <span>{!! __('results') !!}</span>
                </p>
            </div>
        </nav>
    @endif
</div>