<aside class="w-[20rem] h-svh bg-cneutral1 hidden xl:block fixed top-0 left-0 bottom-0 z-50 dark:bg-neutral-950">
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

                <livewire:logout>
            </x-slot>
        </x-dropdown>
    </div>

    <div class="h-[calc(100vh-5rem)] overflow-y-auto">
        <ul class="flex flex-col p-5 pt-2 space-y-4">
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

            <li class="space-y-1.5">
                <p class="text-neutral-400 uppercase text-xs font-semibold tracking-wide dark:text-neutral-600">Utama</p>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.index')" :active="request()->routeIs('dashboard-surat.index')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    {{ __('Dashboard Surat') }}
                </x-nav-link>
            </li>

            <li class="space-y-1.5">
                <p class="text-neutral-400 uppercase text-xs font-semibold tracking-wide dark:text-neutral-600">Surat</p>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.incoming.index')" :active="request()->routeIs('dashboard-surat.incoming.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19.5 12h-15m7.5-7.5v15" />
                    </svg>
                    {{ __('Surat Masuk') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.outgoing.index')" :active="request()->routeIs('dashboard-surat.outgoing.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 12H3m18 0-6 6m6-6-6-6" />
                    </svg>
                    {{ __('Surat Keluar') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.disposisi.index')" :active="request()->routeIs('dashboard-surat.disposisi.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Disposisi Saya') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.template.index')" :active="request()->routeIs('dashboard-surat.template.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                    {{ __('Template Surat') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.incoming.archive')" :active="request()->routeIs('dashboard-surat.incoming.archive')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 7h18M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2M5 7v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7M9 11h6" />
                    </svg>
                    {{ __('Arsip Surat Masuk') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.outgoing.archive')" :active="request()->routeIs('dashboard-surat.outgoing.archive')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 7h18M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2M5 7v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7M9 11h6" />
                    </svg>
                    {{ __('Arsip Surat Keluar') }}
                </x-nav-link>
            </li>

            <li class="space-y-1.5">
                <p class="text-neutral-400 uppercase text-xs font-semibold tracking-wide dark:text-neutral-600">Administrasi</p>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.settings.index')" :active="request()->routeIs('dashboard-surat.settings.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6h16v12H4z" />
                    </svg>
                    {{ __('Pengaturan Surat') }}
                </x-nav-link>
                @if (auth()->user()->role === 'admin')
                    <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.users.index')" :active="request()->routeIs('dashboard-surat.users.*')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.5 20.25a7.5 7.5 0 0 1 15 0" />
                        </svg>
                        {{ __('Manajemen User') }}
                    </x-nav-link>
                @endif
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.notifications.index')" :active="request()->routeIs('dashboard-surat.notifications.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V4a2 2 0 1 0-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                    </svg>
                    {{ __('Notifikasi Surat') }}
                </x-nav-link>
                <x-nav-link class="inline-flex gap-3" :href="route('dashboard-surat.audit.index')" :active="request()->routeIs('dashboard-surat.audit.*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2-11H7a2 2 0 0 0-2 2v12l4-2 4 2 4-2 4 2V7a2 2 0 0 0-2-2z" />
                    </svg>
                    {{ __('Audit Log') }}
                </x-nav-link>
            </li>
        </ul>
    </div>
</aside>
