<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="py-16">
        <x-container>
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Progress ISBN</h2>
                <p class="text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto">
                    Pantau proses pengurusan ISBN buku Anda secara real-time melalui tabel di bawah ini.
                </p>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
                <div class="relative aspect-[16/9]">
                    <iframe
                        src="{{ $settings['progress-isbn'] ?? 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTSn4py3eDAEplDua59b7lcynLw2W79vofW4FziV19YIlFhY3LUnBqA2AbzEgIbKo00crrxaWd7qknZ/pubhtml' }}"
                        class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen="true"
                        mozallowfullscreen="true" webkitallowfullscreen="true">
                    </iframe>
                </div>

                <div class="absolute inset-0 flex items-center justify-center bg-white dark:bg-neutral-800"
                    id="loading">
                    <div class="text-center">
                        <svg class="animate-spin h-8 w-8 text-cgreen-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="text-neutral-600 dark:text-neutral-400">Memuat data...</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-sm text-neutral-500 dark:text-neutral-400 text-center">
                <p>Data diperbarui secara otomatis. Refresh halaman jika tabel tidak muncul.</p>
            </div>
        </x-container>
    </section>

    @push('scripts')
        <script>
            document.querySelector('iframe').addEventListener('load', function() {
                document.getElementById('loading').style.display = 'none';
            });
        </script>
    @endpush
</x-main-layout>
