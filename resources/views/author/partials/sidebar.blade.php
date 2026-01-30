<aside class="w-[20rem] h-svh bg-cneutral1 hidden xl:block fixed top-0 left-0 bottom-0 z-50 dark:bg-neutral-950">
    @php
        $user = auth()->user();
        $can = fn (string $permission) => $user && $user->hasAuthorPermission($permission);
        $canDashboard = $can('author.dashboard.view');
        $canSales = $can('author.sales.view');
        $canPayouts = $can('author.payouts.view');
        $canSettings = $can('author.settings.view');
        $showAuthorMenu = $canDashboard || $canSales || $canPayouts || $canSettings;
    @endphp
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
        <ul class="flex flex-col p-5 pt-2 space-y-1.5">
            <li>
                <x-nav-link class="inline-flex gap-3 text-sm" :href="route('home')">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    {{ __('Kembali ke beranda') }}
                </x-nav-link>
            </li>

            @if ($showAuthorMenu)
                <div class="text-neutral-400 pt-4 uppercase text-sm font-medium dark:text-neutral-600">
                    <p>Dashboard Penulis</p>
                </div>
            @endif

            @if ($canDashboard)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('author.index')" :active="request()->routeIs('author.index')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    {{ __('Ringkasan') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canSales)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('author.sales')" :active="request()->routeIs('author.sales')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <path d="M16,64H240L224,160H48Z" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <circle cx="80" cy="200" r="16" fill="currentColor" />
                        <circle cx="184" cy="200" r="16" fill="currentColor" />
                    </svg>
                    {{ __('Penjualan') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canPayouts)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('author.payouts')" :active="request()->routeIs('author.payouts*')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="size-6">
                        <rect width="256" height="256" fill="none" />
                        <rect x="32" y="64" width="192" height="128" rx="16" stroke="currentColor" stroke-width="16" fill="none" />
                        <line x1="32" y1="104" x2="224" y2="104" stroke="currentColor" stroke-width="16" />
                    </svg>
                    {{ __('Pencairan') }}
                    </x-nav-link>
                </li>
            @endif

            @if ($canSettings)
                <li>
                    <x-nav-link class="inline-flex gap-3" :href="route('author.settings')" :active="request()->routeIs('author.settings')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    {{ __('Pengaturan') }}
                    </x-nav-link>
                </li>
            @endif
        </ul>
    </div>
</aside>
