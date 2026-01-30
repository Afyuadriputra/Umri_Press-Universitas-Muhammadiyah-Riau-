.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Under Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
</head>

<body class="font-sans antialiased bg-neutral-100 dark:bg-neutral-950 overflow-hidden">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <div class="max-w-2xl mx-auto">
            <!-- Logo -->
            <img src="{{ asset('assets/img/logo-white.png') }}" alt="UMRI Press" class="h-16 mx-auto mb-8">

            <!-- Maintenance Icon -->
            <div class="mb-8 text-red-500 dark:text-red-400">
                <svg class="w-24 h-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>

            <!-- Main Content -->
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-neutral-100 mb-4">
                Under Maintenance
            </h1>

            <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8">
                Sebentar yaa, kami sedang melakukan pemeliharaan sistem dulu. Terima kasih sudah sabar menunggu.
            </p>

            <!-- Estimated Time -->
            @if (isset($exception) && !empty($exception->wentDownAt))
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-200 dark:bg-neutral-800 rounded-full text-sm text-neutral-700 dark:text-neutral-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Estimated downtime: {{ $exception->wentDownAt->diffForHumans() }}
                </div>
            @endif

            <!-- Contact Info -->
            <div class="mt-12">
                <p class="text-sm text-neutral-500 dark:text-neutral-500">
                    If you need immediate assistance, please contact us at:
                </p>
                <a href="mailto:{{ config('app.admin_email', 'umripres@umri.ac.id') }}"
                    class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 font-medium">
                    {{ config('app.admin_email', 'umripres@umri.ac.id') }}
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="absolute bottom-6 text-sm text-neutral-500 dark:text-neutral-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </div>

    <!-- Dark Mode Detection -->
    <script>
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>

</html>
