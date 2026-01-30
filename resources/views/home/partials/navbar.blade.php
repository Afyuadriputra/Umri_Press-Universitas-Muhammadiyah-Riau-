<nav x-data="{
    open: false,
    aboutDropdown: false,
    layananDropdown: false,
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.pageYOffset > 20
        })
    }
}" :class="{
    'sticky top-4 px-8': scrolled,
    'sticky top-0': !scrolled
}"
    class="w-full z-50 transition-all duration-500">
    <div :class="{
        'lg:w-7xl mx-auto rounded-2xl bg-white/90 dark:bg-neutral-950/90 backdrop-blur border border-neutral-300 dark:border-neutral-900': scrolled,
        'rounded-none mx-auto bg-white dark:bg-neutral-950 w-full border-b border-neutral-300 dark:border-neutral-900':
            !scrolled
    }"
        class=" transition-all duration-300">
        <div class=" max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" wire:navigate.hover>
                        <img class="h-8 sm:h-10 w-auto dark:hidden" src="{{ asset($settings['logo'] ?? 'assets/img/logo.png') }}" alt="Logo">
                        <img class="h-8 sm:h-10 w-auto hidden dark:block" src="{{ asset($settings['logo-white'] ?? 'assets/img/logo-white.png') }}"
                            alt="Logo">
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-0.5">
                    <a href="{{ route('home') }}" wire:navigate.hover
                        class=" px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 {{ request()->routeIs('home') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400' }}">
                        Beranda
                    </a>

                    <!-- About Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseover="open = true" @mouseleave="open = false">
                        <button
                            class="px-4 py-2 rounded-full text-sm transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 inline-flex items-center cursor-pointer {{ request()->is('tentang*') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200 font-medium hover:text-cgreen-500 dark:hover:text-cgreen-400' }}">
                            <span>Tentang</span>
                            <svg class="ml-1.5 h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-56 rounded-xl shadow-xl bg-white dark:bg-neutral-800 ring-opacity-5 overflow-hidden">
                            <div class="py-1">
                                <a href="{{ route('team') }}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm text-neutral-700 dark:text-neutral-200 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('team') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : '' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('team') ? 'opacity-100' : '' }}"></span>
                                    Tim
                                </a>
                                <a href="{{ route('tentangKami') }}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm text-neutral-700 dark:text-neutral-200 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('tentangKami') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : '' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('tentangKami') ? 'opacity-100' : '' }}"></span>
                                    Profil Usaha
                                </a>

                                <a href="#"
                                    class="group flex items-center px-4 py-3 text-sm text-neutral-700 dark:text-neutral-200 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3"></span>
                                    Testimonial
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }" @mouseover="open = true" @mouseleave="open = false">
                        <button
                            class="px-4 py-2 rounded-full text-sm transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 inline-flex items-center cursor-pointer {{ request()->is('layanan*') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200 font-medium hover:text-cgreen-500 dark:hover:text-cgreen-400' }}">
                            <span>Layanan</span>
                            <svg class="ml-1.5 h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-64 rounded-xl shadow-xl bg-white dark:bg-neutral-800 ring-opacity-5 overflow-hidden">
                            <div class="py-1">
                                <a href="{{ route('daftarPenulis') }}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('daftarPenulis') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('daftarPenulis') ? 'opacity-100' : '' }}"></span>
                                    Daftar Menerbitkan Buku
                                </a>
                                <a href="{{route('penjelasanLayanan')}}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('penjelasanLayanan') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('penjelasanLayanan') ? 'opacity-100' : '' }}"></span>
                                    Penjelasan Layanan
                                </a>
                                <a href="{{ route('kirimNaskah') }}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('kirimNaskah') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('kirimNaskah') ? 'opacity-100' : '' }}"></span>
                                    Kirim Naskah
                                </a>
                                <a href="{{ route('progressISBN') }}" wire:navigate
                                    class="group flex items-center px-4 py-3 text-sm hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('progressISBN') ? 'bg-cgreen-50 dark:bg-cgreen-900/30 text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">
                                    <span
                                        class="w-2 h-2 rounded-full bg-cgreen-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-3 {{ request()->routeIs('progressISBN') ? 'opacity-100' : '' }}"></span>
                                    Progress ISBN
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tokoBuku') }}" wire:navigate
                        class="hover:text-cgreen-500 dark:hover:text-cgreen-400 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 {{ request()->routeIs('tokoBuku') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">Toko
                        Buku</a>
                    <a href="{{ route('kontak') }}" wire:navigate
                        class="hover:text-cgreen-500 dark:hover:text-cgreen-400 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 {{ request()->routeIs('kontak') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }}">Kontak</a>
                    <a href="{{ route('artikel') }}" wire:navigate
                        class="{{ request()->routeIs('artikel') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : 'text-neutral-700 dark:text-neutral-200' }} hover:text-cgreen-500 dark:hover:text-cgreen-400 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50">Artikel</a>
                </div>

                <div class="flex items-center space-x-2">
                    <div class="hidden lg:flex items-center ml-4">
                        @auth
                            <a href="{{ route('dashboard') }}">
                                <x-primary-button>Dashboard</x-primary-button>
                            </a>
                        @else
                            <a href="{{ $settings['gform'] }}" target="_blank">
                                <x-primary-button>Kirim Naskah</x-primary-button>
                            </a>
                        @endauth
                    </div>

                    {{-- darkmode --}}
                    <div class="flex items-center space-x-2">
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

                        <div class="flex items-center lg:hidden">
                            <button @click="open = !open"
                                class="inline-flex items-center justify-center p-2 rounded-full text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 hover:bg-cgreen-100 dark:hover:bg-cgreen-800 focus:outline-none transition-all duration-300">
                                <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="lg:hidden bg-white/95 dark:bg-neutral-900/95 backdrop-blur overflow-y-auto max-h-screen overflow-hidden">
            <div class="px-4 pt-2 pb-3 space-y-1" x-cloak>
                <a href="{{ route('home') }}" wire:navigate.hover
                    class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Beranda</a>

                <!-- Mobile About Dropdown -->
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full text-left px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 flex justify-between items-center">
                        <span>Tentang Kami</span>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="pl-4">
                        <a href="{{ route('team') }}"
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Tim</a>
                        <a href="{{ route('tentangKami') }}"
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Profil Usaha</a>
                        <a href="#"
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Testimonial</a>
                    </div>
                </div>

                <!-- Mobile Layanan Dropdown -->
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full text-left px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 flex justify-between items-center">
                        <span>Layanan</span>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="pl-4">
                        <a href="{{ route('daftarPenulis') }}" wire:navigate.hover
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Daftar
                            Menerbitkan Buku</a>
                        <a href="{{ route('penjelasanLayanan') }}" wire:navigate
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Penjelasan
                            Layanan</a>
                        <a href="{{ route('kirimNaskah') }}" wire:navigate.hover
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('kirimNaskah') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : '' }}">Kirim
                            Naskah</a>
                        <a href="{{ route('progressISBN') }}" wire:navigate.hover
                            class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300 {{ request()->routeIs('progressISBN') ? 'font-semibold text-cgreen-500 dark:text-cgreen-400' : '' }}">
                            Progress ISBN
                        </a>
                    </div>
                </div>
                <a href="{{ route('tokoBuku') }}" wire:navigate.hover
                    class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Toko
                    Buku</a>
                <a href="{{ route('kontak') }}" wire:navigate.hover
                    class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Kontak</a>
                <a href="{{ route('artikel') }}" wire:navigate.hover
                    class="block px-4 py-3 rounded-lg text-base font-medium text-neutral-700 dark:text-neutral-200 hover:text-cgreen-500 dark:hover:text-cgreen-400 hover:bg-cgreen-100 dark:hover:bg-cgreen-900/50 transition-all duration-300">Artikel</a>

                <!-- Mobile Login Button -->
                <div class="mt-6 px-4 pb-4">
                    <a href="">
                        <x-primary-button>Kirim Naskah</x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
