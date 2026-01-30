<x-app-layout>
    <div class="p-6">
        <div class="mb-8">
            <h2 class="font-semibold text-2xl text-neutral-900 dark:text-neutral-100">Dashboard</h2>
            <p class="text-neutral-600 dark:text-neutral-400">Selamat datang di halaman dashboard
                {{ config('app.name') }}</p>
        </div>
        @php
            $user = auth()->user();
            $can = fn (string $permission) => $user && $user->hasDashboardPermission($permission);
            $showBuku = $can('buku.view');
            $showArtikel = $can('artikel.view');
            $showPaket = $can('harga.view');
            $showTim = $can('tim.view');
            $showRoles = $can('roles.manage');
            $showUsers = $can('users.manage');
            $showSettings = $can('settings.manage');
            $showAnyStat = $showBuku || $showArtikel || $showPaket || $showTim;
            $showQuickActions = $showRoles || $showUsers || $showSettings;
        @endphp

        <!-- Stats Grid -->
        @if ($showAnyStat)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Buku -->
            @if ($showBuku)
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-neutral-500 dark:text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div
                        class="bg-cgreen-100 dark:bg-cgreen-900/20 text-cgreen-600 dark:text-cgreen-400 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Total Buku
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalBuku }}</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Buku</p>
                </div>
                </div>
            @endif

            <!-- Total Artikel -->
            @if ($showArtikel)
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-neutral-500 dark:text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div
                        class="bg-cgreen-100 dark:bg-cgreen-900/20 text-cgreen-600 dark:text-cgreen-400 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Total Artikel
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalArtikel }}</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Artikel</p>
                </div>
                </div>
            @endif

            <!-- Total Paket -->
            @if ($showPaket)
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-neutral-500 dark:text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div
                        class="bg-cgreen-100 dark:bg-cgreen-900/20 text-cgreen-600 dark:text-cgreen-400 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Total Paket
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalPaket }}</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Paket</p>
                </div>
                </div>
            @endif

            <!-- Total Tim -->
            @if ($showTim)
                <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-neutral-500 dark:text-neutral-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div
                        class="bg-cgreen-100 dark:bg-cgreen-900/20 text-cgreen-600 dark:text-cgreen-400 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Total Tim
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalTim }}</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Anggota</p>
                </div>
                </div>
            @endif
        </div>
        @else
            <div class="mb-8 rounded-xl border border-neutral-200 bg-white p-6 text-sm text-neutral-600 dark:border-neutral-800 dark:bg-neutral-900 dark:text-neutral-300">
                Anda belum memiliki akses untuk melihat ringkasan statistik.
            </div>
        @endif

        @if ($showQuickActions)
            <div class="mb-8">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Akses Cepat</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Kelola fitur penting secara cepat.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if ($showRoles)
                        <a href="{{ route('roles.index') }}" wire:navigate
                            class="group rounded-xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:border-cgreen-200 hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Roles</p>
                                    <h4 class="mt-1 text-base font-semibold text-neutral-900 dark:text-neutral-100">Manajemen Role</h4>
                                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Tambah, edit, dan atur izin role.</p>
                                </div>
                                <div class="rounded-lg bg-cgreen-50 p-3 text-cgreen-600 transition group-hover:bg-cgreen-100 dark:bg-cgreen-900/20 dark:text-cgreen-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                                        <rect width="256" height="256" fill="none" />
                                        <circle cx="64" cy="64" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="192" cy="64" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="64" cy="192" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="192" cy="192" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <path d="M88 64h80M64 88v80M88 192h80M192 88v80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if ($showUsers)
                        <a href="{{ route('semuaUsers') }}" wire:navigate
                            class="group rounded-xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:border-cgreen-200 hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Users</p>
                                    <h4 class="mt-1 text-base font-semibold text-neutral-900 dark:text-neutral-100">Manajemen Pengguna</h4>
                                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Kelola user dan hak akses.</p>
                                </div>
                                <div class="rounded-lg bg-cgreen-50 p-3 text-cgreen-600 transition group-hover:bg-cgreen-100 dark:bg-cgreen-900/20 dark:text-cgreen-400">
                                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none" />
                                        <circle cx="128" cy="120" r="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <path d="M48 208a80 80 0 0 1 160 0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="52" cy="92" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="204" cy="92" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if ($showSettings)
                        <a href="{{ route('pengaturanWeb') }}" wire:navigate
                            class="group rounded-xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:border-cgreen-200 hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Pengaturan</p>
                                    <h4 class="mt-1 text-base font-semibold text-neutral-900 dark:text-neutral-100">Pengaturan Web</h4>
                                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Atur tampilan dan konfigurasi.</p>
                                </div>
                                <div class="rounded-lg bg-cgreen-50 p-3 text-cgreen-600 transition group-hover:bg-cgreen-100 dark:bg-cgreen-900/20 dark:text-cgreen-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if ($showBuku)
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Buku Terbaru</h3>
                    </div>
                    <div class="p-6">
                        @if ($recentBooks->count() > 0)
                            <div class="space-y-4 grid grid-cols-2 gap-3">
                                @foreach ($recentBooks as $book)
                                    <a href="{{ route('editBuku', $book->slug) }}" wire:navigate
                                        class="flex items-center gap-4 p-2 hover:bg-neutral-200/70 rounded-lg duration-200">
                                        <img src="{{ asset($book->cover_thumbnail) }}" alt="{{ $book->judul }}"
                                            class="w-12 object-cover rounded-lg">
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-sm font-medium text-neutral-900 dark:text-neutral-100 line-clamp-2 capitalize">
                                                {{ $book->judul }}
                                            </p>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400 capitalize">
                                                {{ $book->authors->first()->name }}
                                            </p>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ \Carbon\Carbon::parse($book->tanggal_terbit)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-neutral-500 dark:text-neutral-400 text-sm">Belum ada buku yang ditambahkan</p>
                        @endif
                    </div>
                </div>
            @endif

            @if ($showArtikel)
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
                    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Artikel Terbaru</h3>
                    </div>
                    <div class="p-6">
                        @if ($recentArticles->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentArticles as $article)
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset($article->gambar) }}" alt="{{ $article->judul }}"
                                            class="w-16 h-12 object-cover rounded-lg">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100 truncate">
                                                {{ $article->judul }}
                                            </p>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                                {{ $article->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-neutral-500 dark:text-neutral-400 text-sm">Belum ada artikel yang ditambahkan</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
