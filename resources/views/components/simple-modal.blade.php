@php
    $modalName = $name ?? 'simple-modal';
    $maxWidth = $maxWidth ?? '2xl';
    $show = $show ?? false;
@endphp

<div
    x-data="{ open: @js($show) }"
    x-on:open-simple-modal.window="if ($event.detail?.name === '{{ $modalName }}') open = true"
    x-on:close-simple-modal.window="if ($event.detail?.name === '{{ $modalName }}') open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    <div class="absolute inset-0 bg-black/50" x-on:click="open = false"></div>

    <div
        class="relative z-10 w-full max-w-{{ $maxWidth }} rounded-2xl bg-white p-6 shadow-xl dark:bg-neutral-900"
        x-trap.noscroll="open"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                @isset($title)
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-50">
                        {{ $title }}
                    </h3>
                @endisset
                @isset($description)
                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                        {{ $description }}
                    </p>
                @endisset
            </div>
            <button
                type="button"
                class="text-neutral-400 transition hover:text-neutral-600"
                x-on:click="open = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
