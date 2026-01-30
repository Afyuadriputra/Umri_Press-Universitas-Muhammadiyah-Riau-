<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' | ' : '' }} Dashboard {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @livewireStyles
</head>

<body class="font-inter antialiased bg-cneutral1 dark:bg-neutral-950" onload="startTime()">
    <div class="min-h-screen p-2">
        <livewire:layout.navigation />
        @include('dashboard.partials.sidebar')

        <main class="bg-white dark:bg-neutral-900 min-h-screen xl:ml-[20rem] rounded-3xl lg:m-2 border border-neutral-300 dark:border-neutral-800">
            <div class="border-b border-neutral-300 dark:border-neutral-800 py-4 flex flex-wrap gap-4 items-center justify-between w-full">
                <x-d-breadcrumb class="!m-0 !p-0" />

                <div class="px-4 md:px-6 lg:px-8 inline-flex items-center gap-3">
                    @persist('time')
                        <div
                            class="inline-flex items-center gap-2 w-full text-center border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 px-4 py-2 rounded-full text-sm font-semibold hover:border-neutral-400 transition-all duration-300 active:scale-95 tracking-wide cursor-pointer">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none" />
                                <circle cx="128" cy="128" r="96" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                <polyline points="128 72 128 128 184 128" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            </svg>
                            <span id="time"></span>
                        </div>
                        @endpersist
                        <button id="darkModeToggle"
                            class="inline-flex items-center justify-center p-2 rounded-full bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors duration-300 focus:outline-none cursor-pointer"
                            aria-label="Toggle dark mode">
                            <!-- Sun icon (shows in light mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 dark:hidden"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <!-- Moon icon (shows in dark mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cgreen-500 hidden dark:block"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                </div>
            </div>

            <div class="pt-4 md:pt-6">
                <x-d-container>
                    {{ $slot }}
                </x-d-container>
            </div>
        </main>
    </div>

    <script>
        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            };
            return i;
        }
    </script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
