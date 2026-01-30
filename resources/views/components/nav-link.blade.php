@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center py-2.5 px-3 rounded-xl font-medium bg-white dark:bg-neutral-900 dark:border-neutral-800 border border-neutral-300 w-full relative'
            : 'inline-flex items-center py-2.5 px-3 rounded-xl font-medium leading-5 text-neutral-600 hover:text-neutral-800 hover:bg-white border border-transparent hover:border-neutral-300 w-full focus:outline-none transition duration-150 ease-in-out relative dark:hover:bg-neutral-900 dark:hover:border-neutral-800 dark:hover:text-neutral-200 dark:text-neutral-400';
@endphp

<div class="relative group">
    @if ($active ?? false)
        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-cgreen-500 rounded"></span>
    @else
        <span
            class="opacity-0 invisible group-hover:opacity-100 group-hover:visible absolute left-0 top-1/2 -translate-y-1/2 w-1 h-0 group-hover:h-6 bg-cgreen-500 rounded duration-300"></span>
    @endif
    <div class="{{ $active ?? false ? 'pl-4' : 'hover:pl-4' }} duration-300">
        <a {{ $attributes->merge(['class' => $classes]) }}>
            {{ $slot }}
        </a>
    </div>
</div>
