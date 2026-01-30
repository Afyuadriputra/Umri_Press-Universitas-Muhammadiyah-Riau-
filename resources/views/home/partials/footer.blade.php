<footer class="bg-neutral-900 dark:border-t dark:border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <img src="{{ asset($settings['logo-white'] ?? 'assets/img/logo-white.png') }}" alt="Logo"
                    class="h-14" />
                <p class="text-neutral-400 text-sm">
                    UMRI Press adalah platform publikasi yang kredibel untuk karya ilmiah, buku akademik, dan jurnal
                    penelitian dengan standar mutu internasional.
                </p>
                <div class="flex space-x-4">
                    <a target="_blank" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['phone'] ?? '') }}" title="WhatsApp"
                        class="text-neutral-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </a>
                    <a href="mailto:{{ $settings['email'] ?? 'umripres@umri.ac.id' }}" title="Email"
                        class="text-neutral-400 hover:text-white transition-colors">
                        <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" wire:navigate
                            class="text-neutral-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="#" class="text-neutral-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('harga') }}" wire:navigate
                            class="text-neutral-400 hover:text-white transition-colors">Harga</a></li>
                    <li><a href="{{ route('kontak') }}" wire:navigate
                            class="text-neutral-400 hover:text-white transition-colors">Kontak</a></li>
                    <li><a href="{{ route('artikel') }}" wire:navigate
                            class="text-neutral-400 hover:text-white transition-colors">Berita</a></li>
                </ul>
            </div>
            <!-- Contact Info -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Contact Info</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-neutral-400 gap-2">
                        <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $settings['address'] ?? 'Jl. Tuanku Tambusai, Delima, Kec. Tampan, Kota Pekanbaru, Riau' }}
                    </li>
                    <li class="flex items-center text-neutral-400 gap-2">
                        <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>

                        {{ $settings['phone'] ?? '+62 878-3715-1510' }}
                    </li>
                    <li class="flex items-center text-neutral-400 gap-2">
                        <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                        {{ $settings['email'] ?? 'umripres@umri.ac.id' }}
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Layanan</h3>
                <ul class="space-y-2">
                    <li class="text-neutral-400">Penerbitan Buku</li>
                    <li class="text-neutral-400">Jasa Parafrase</li>
                    <li class="text-neutral-400">Jasa Pengurusan HAKI</li>
                    <li class="text-neutral-400">Konsultasi Penulisan</li>
                    <li class="text-neutral-400">Toko Buku</li>
                </ul>
            </div>
        </div>
        <!-- Bottom Bar -->
        <div class="border-t border-neutral-800 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-neutral-400 text-sm">© {{ date('Y') }} {{ config('app.name') }}. All rights
                    reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0"><a href="#"
                        class="text-neutral-400 hover:text-white text-sm transition-colors">Privacy Policy</a><a
                        href="#" class="text-neutral-400 hover:text-white text-sm transition-colors">Terms of
                        Service</a><a href="#"
                        class="text-neutral-400 hover:text-white text-sm transition-colors">Cookie Policy</a></div>
            </div>
        </div>
    </div>
</footer>
