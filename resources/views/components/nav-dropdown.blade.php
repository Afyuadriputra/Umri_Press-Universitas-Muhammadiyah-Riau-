@props(['title', 'icon', 'active' => false, 'routePattern', 'contentClasses' => 'mt-2 space-y-1'])

<li>
    <div x-data="{ isExpanded: {{ request()->is($routePattern) ? 'true' : 'false' }} }" class="flex flex-col {{ $active ?? false ? 'pl-4' : 'hover:pl-4' }} duration-300 relative group">
        @if ($active)
            <span class="opacity-100 visible absolute left-0 top-2 w-1 h-6 bg-cgreen-500 rounded"></span>
        @else
            <span
                class="opacity-0 invisible group-hover:opacity-100 group-hover:visible absolute left-0 top-2 w-1 h-0 group-hover:h-6 bg-cgreen-500 rounded duration-300"></span>
        @endif
        <button type="button" x-on:click="isExpanded = ! isExpanded" aria-controls="{{ Str::slug($title) }}"
            x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
            class="inline-flex items-center py-2.5 px-3 rounded-xl font-medium leading-5 gap-3 w-full focus:outline-none cursor-pointer hover:bg-white dark:hover:bg-neutral-900 border border-transparent duration-200  hover:border-neutral-300 dark:hover:border-neutral-800"
            x-bind:class="isExpanded ? 'text-black dark:text-neutral-200 dark:bg-neutral-900 dark:!border-neutral-800 bg-white border !border-neutral-300' :
                ' text-neutral-600 hover:bg-white hover:text-black dark:hover:text-neutral-200 dark:text-neutral-400'">

            {!! $icon !!}

            <span class="mr-auto text-left">{{ $title }}</span>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="size-5 transition-transform shrink-0" x-bind:class="isExpanded ? 'rotate-180' : 'rotate-0'"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <div x-cloak x-collapse x-show="isExpanded" aria-labelledby="{{ Str::slug($title) }}-btn"
            id="{{ Str::slug($title) }}">
            <ul class="{{ $contentClasses }}">
                {{ $slot }}
            </ul>
        </div>
    </div>
</li>
