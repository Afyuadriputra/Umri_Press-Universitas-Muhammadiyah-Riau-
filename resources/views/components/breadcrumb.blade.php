@props(['class' => ''])

<div class="py-4 bg-white dark:bg-neutral-950 {{ $class }}">
    <x-container>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" wire:navigate
                        class="inline-flex items-center text-sm font-medium text-neutral-700 dark:text-neutral-400 duration-200 hover:text-cgreen-500">
                        <svg class="size-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path
                                d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                        </svg>
                        Home
                    </a>
                </li>

                @php
                    $segments = request()->segments();
                @endphp

                @foreach ($segments as $index => $segment)
                    @php
                        $name = str_replace('-', ' ', $segment);
                        $name = ucwords($name);
                    @endphp
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-neutral-400 dark:text-neutral-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            @if ($index === count($segments) - 1)
                                <span class="ml-1 text-sm font-medium text-neutral-500 dark:text-neutral-200 md:ml-2">{{ $name }}</span>
                            @else
                                <span class="ml-1 text-sm font-medium text-neutral-700 dark:text-neutral-400 md:ml-2">{{ $name }}</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </nav>
    </x-container>
</div>
