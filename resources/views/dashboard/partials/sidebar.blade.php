<aside class="w-[20rem] h-svh bg-cneutral1 hidden xl:block fixed top-0 left-0 bottom-0 z-50 dark:bg-neutral-950">
    @php
        $user = auth()->user();
        $can = fn (string $permission) => $user && $user->hasDashboardPermission($permission);
        $canDashboard = $can('dashboard.view');
        $canBukuMenu = $can('buku.view') || $can('buku.create') || $can('buku.category.view') || $can('komentar.manage');
        $canAuthors = $can('authors.manage');
        $canArtikelMenu = $can('artikel.view') || $can('artikel.create') || $can('artikel.category.manage');
        $canHarga = $can('harga.view');
        $canTim = $can('tim.view') || $can('tim.create') || $can('tim.update');
        $canSertifikat = $can('sertifikat.manage');
        $canPembayaran = $can('pembayaran.manage');
        $canTransaksi = $can('transaksi.view');
        $canRoyalty = $can('royalty.manage');
        $canPayouts = $can('payouts.manage');
        $canUsers = $can('users.manage');
        $canRoles = $can('roles.manage');
        $canSettings = $can('settings.manage');
        $showMainMenu = $canDashboard || $canBukuMenu || $canAuthors || $canArtikelMenu || $canHarga || $canTim || $canSertifikat;
        $showTransaksi = $canPembayaran || $canTransaksi || $canRoyalty || $canPayouts;
        $showPengaturan = $canUsers || $canRoles || $canSettings;
    @endphp
    <!-- Logo -->
    <div class="shrink-0 flex items-center p-5 pb-0">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center justify-between w-full border p-3 border-neutral-300 dark:border-neutral-900 rounded-lg bg-white dark:bg-neutral-900 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/img/favicon.png') }}" class="h-12"
                            alt="{{ config('app.name', 'Laravel') }} Logo">
                        <div>
                            <h5 class="font-semibold line-clamp-2 capitalize leading-none text-left">Halo,
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="text-sm text-neutral-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div>
                        <svg class="size-5 text-neutral-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <polyline points="80 176 128 224 176 176" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <polyline points="80 80 128 32 176 80" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <livewire:logout>
            </x-slot>
        </x-dropdown>
    </div>

    <div class="h-[calc(100vh-5rem)] overflow-y-auto">
        <ul class="flex flex-col p-5 pt-2 space-y-1.5">

            <li>
                <x-nav-link class="inline-flex gap-3 text-sm" :href="route('home')">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    {{ __('Kembali ke beranda') }}
                </x-nav-link>
            </li>

            @if ($showMainMenu)
                <div class="text-neutral-400 pt-4 uppercase text-sm font-medium dark:text-neutral-600">
                    <p>Main menu</p>
                </div>
            @endif

            @if ($canDashboard)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>

                    {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canBukuMenu)
                <li>
                    <x-nav-dropdown title="Data Buku" routePattern="dashboard/buku*" :active="request()->is('dashboard/buku*')"
                        icon='<svg class="size-6 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M48,216a24,24,0,0,1,24-24H208V32H72A24,24,0,0,0,48,56Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="48 216 48 224 192 224" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>'>

                        <ul>
                            @if ($can('buku.category.view'))
                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('semuaKategori') }}" wire:navigate
                                        class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('semuaKategori') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                        Kategori
                                    </a>
                                </li>
                            @endif
                            @if ($can('buku.view'))
                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('semuaBuku') }}" wire:navigate
                                        class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('semuaBuku') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                        Semua Buku
                                    </a>
                                </li>
                            @endif
                            @if ($can('buku.create'))
                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('tambahBuku') }}" wire:navigate
                                        class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('tambahBuku') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                        Tambah Buku
                                    </a>
                                </li>
                            @endif
                            @if ($can('komentar.manage'))
                                <li class="px-1 py-0.5 first:mt-2">
                                    <a href="{{ route('semuaKomentar') }}" wire:navigate
                                        class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('semuaKomentar') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                        Semua Komentar
                                    </a>
                                </li>
                            @endif
                        </ul>

                    </x-nav-dropdown>
                </li>
            @endif

            @if ($canAuthors)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('semuaAuthors')" :active="request()->routeIs('semuaAuthors')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>


                    {{ __('Data Authors') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canArtikelMenu)
                <li>
                    <x-nav-dropdown title="Artikel" routePattern="dashboard/artikel*" :active="request()->is('dashboard/artikel*')"
                    icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>'>

                    <ul>
                        @if ($can('artikel.category.manage'))
                            <li class="px-1 py-0.5 first:mt-2">
                                <a href="{{ route('kategoriArtikel') }}" wire:navigate
                                    class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('kategoriArtikel') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                    Kategori
                                </a>
                            </li>
                        @endif
                        @if ($can('artikel.view'))
                            <li class="px-1 py-0.5 first:mt-2">
                                <a href="{{ route('semuaArtikel') }}" wire:navigate
                                    class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('semuaArtikel') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                    Semua Artikel
                                </a>
                            </li>
                        @endif
                        @if ($can('artikel.create'))
                            <li class="px-1 py-0.5 first:mt-2">
                                <a href="{{ route('tambahArtikel') }}" wire:navigate
                                    class="flex items-center rounded-lg gap-2 px-4 py-1.5 focus:outline-none font-medium border duration-150 {{ request()->routeIs('tambahArtikel') ? 'border-neutral-300 text-neutral-800 dark:text-neutral-200 dark:border-neutral-800' : 'border-transparent hover:border-neutral-300 text-neutral-600 hover:text-neutral-800 dark:hover:border-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200' }}">
                                    Tambah Artikel
                                </a>
                            </li>
                        @endif
                    </ul>

                    </x-nav-dropdown>
                </li>
            @endif

            @if ($canHarga)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('semuaPaket')" :active="request()->routeIs('semuaPaket')" wire:navigate>
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <path d="M240,186.79c-91.64,44.77-132.36-42.35-224,2.42v-120c91.64-44.77,132.36,42.35,224-2.42Z"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16" />
                        <circle cx="128" cy="128" r="24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <line x1="48" y1="96" x2="48" y2="144" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16" />
                        <line x1="208" y1="112" x2="208" y2="160" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16" />
                    </svg>
                    {{ __('Harga Paket') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canTim)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('semuaTim')" :active="request()->routeIs('semuaTim')" wire:navigate>
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <circle cx="80" cy="168" r="32" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="80" cy="64" r="32" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="176" cy="168" r="32" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M32,224a60,60,0,0,1,96,0,60,60,0,0,1,96,0" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="176" cy="64" r="32" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M32,120a60,60,0,0,1,96,0h0a60,60,0,0,1,96,0" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    </svg>

                    {{ __('Tim') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canSertifikat)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('semuaSertifikat')" :active="request()->routeIs('semuaSertifikat')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 9V5.6a1.6 1.6 0 0 1 1.6-1.6h8.8A1.6 1.6 0 0 1 18 5.6V18.4a1.6 1.6 0 0 1-1.6 1.6H7.6A1.6 1.6 0 0 1 6 18.4V15m0-6h4m-4 0V15m0 0h4" />
                    </svg>
                    {{ __('Sertifikat') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($showTransaksi)
                <div class="text-neutral-400 pt-4 uppercase text-sm font-medium dark:text-neutral-600">
                    <p>Transaksi</p>
                </div>
            @endif

            @if ($canPembayaran)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('metodePembayaran')" :active="request()->routeIs('metodePembayaran')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <rect x="32" y="64" width="192" height="128" rx="16" stroke="currentColor" stroke-width="16" fill="none" />
                        <line x1="32" y1="104" x2="224" y2="104" stroke="currentColor" stroke-width="16" />
                    </svg>
                    {{ __('Metode Pembayaran') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canTransaksi)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('pesananLangsung')" :active="request()->routeIs('pesananLangsung')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <path d="M16,64H240L224,160H48Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="80" cy="200" r="16" fill="currentColor" />
                        <circle cx="184" cy="200" r="16" fill="currentColor" />
                    </svg>
                    {{ __('Pesanan Langsung') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canRoyalty)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('dashboard.royalty.index')" :active="request()->routeIs('dashboard.royalty.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <path d="M32 80h192v112H32z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M32 112h192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="92" cy="152" r="12" fill="currentColor" />
                    </svg>
                    {{ __('Royalti Penulis') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canPayouts)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('dashboard.payouts.index')" :active="request()->routeIs('dashboard.payouts.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <path d="M32 64h192v128H32z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M32 104h192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M80 144h96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    </svg>
                    {{ __('Pencairan Penulis') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($showPengaturan)
                <div class="text-neutral-400 pt-4 uppercase text-sm font-medium dark:text-neutral-600">
                    <p>Pengaturan</p>
                </div>
            @endif

            @if ($canUsers)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('semuaUsers')" :active="request()->routeIs('semuaUsers')" wire:navigate>
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <path d="M192,120a59.91,59.91,0,0,1,48,24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M16,144a59.91,59.91,0,0,1,48-24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="128" cy="144" r="40" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M72,216a65,65,0,0,1,112,0" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M161,80a32,32,0,1,1,31,40" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M64,120A32,32,0,1,1,95,80" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    </svg>

                    {{ __('Users') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canRoles)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('roles.index')" :active="request()->routeIs('roles.index')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <circle cx="64" cy="64" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="192" cy="64" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="64" cy="192" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="192" cy="192" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path d="M88 64h80M64 88v80M88 192h80M192 88v80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    </svg>

                    {{ __('Roles') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canSettings)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('pengaturanWeb')" :active="request()->routeIs('pengaturanWeb')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    {{ __('Pengaturan Web') }}
                    </x-nav-link>
                </li>
            @endif
        </ul>
    </div>
</aside>
