<x-main-layout>
    @php
        $waNumber = \App\Models\Pengaturan::where('key', 'admin_wa_number')->value('value') ?? '6287837151510';
        $waMessage = rawurlencode("Halo UMRI Press, saya ingin membeli buku \"{$book->judul}\".\nJumlah: 1\nNama:\nAlamat lengkap:\nMetode pengiriman:\nMetode pembayaran:");
    @endphp
    
    <section class="py-8">
        <x-container>
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                <!-- Main Content -->
                <div class="w-full lg:w-3/4">
                    <div class="bg-white dark:bg-neutral-900 rounded-2xl overflow-hidden shadow-sm border border-neutral-100 dark:border-neutral-800">
                        
                        <!-- Book Header Section -->
                        <div class="p-6 md:p-8 lg:p-10">
                            <div class="flex flex-col md:flex-row gap-8">
                                
                                <!-- Book Cover -->
                                <div class="w-full md:w-64 flex-shrink-0 mx-auto md:mx-0">
                                    <div class="relative aspect-[2/3] overflow-hidden rounded-xl shadow-xl ring-1 ring-black/5 dark:ring-white/10">
                                        <img src="{{ asset($book->cover) }}" 
                                             alt="{{ $book->judul }}"
                                             class="h-full w-full object-cover transition-transform duration-700 hover:scale-105" 
                                             loading="eager" />
                                    </div>
                                </div>

                                <!-- Book Info -->
                                <div class="flex-1 space-y-6">
                                    
                                    <!-- Title -->
                                    <div>
                                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold leading-tight text-neutral-900 dark:text-neutral-50 mb-2">
                                            {{ $book->judul }}
                                        </h1>
                                        
                                        <!-- Authors -->
                                        <div class="flex flex-wrap items-center gap-2 text-neutral-600 dark:text-neutral-400">
                                            <span class="text-sm">oleh</span>
                                            @foreach ($book->authors as $index => $author)
                                                <a href="{{ route('author', $author->slug) }}" 
                                                   wire:navigate
                                                   class="text-sm font-medium text-cgreen-600 hover:text-cgreen-700 hover:underline dark:text-cgreen-400 dark:hover:text-cgreen-300">
                                                    {{ $author->name }}
                                                </a>
                                                @if(!$loop->last) 
                                                    <span class="text-neutral-400">&</span> 
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Meta Info Grid -->
                                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-neutral-200 dark:border-neutral-700">
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Kategori</dt>
                                            <dd>
                                                <a href="{{ route('kategori', $book->kategori->slug) }}" 
                                                   wire:navigate
                                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-cgreen-100 text-cgreen-700 hover:bg-cgreen-200 dark:bg-cgreen-900/30 dark:text-cgreen-400 dark:hover:bg-cgreen-900/50 transition-colors">
                                                    {{ $book->kategori->nama }}
                                                </a>
                                            </dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Penerbit</dt>
                                            <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">UmriPress</dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">ISBN</dt>
                                            <dd class="text-sm font-mono text-neutral-900 dark:text-neutral-100">{{ $book->isbn }}</dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Halaman</dt>
                                            <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $book->jumlah_halaman }} hal</dd>
                                        </div>
                                        
                                        @if ($book->eisbn)
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">E-ISBN</dt>
                                            <dd class="text-sm font-mono text-neutral-900 dark:text-neutral-100">{{ $book->eisbn }}</dd>
                                        </div>
                                        @endif
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Terbit</dt>
                                            <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                                {{ \Carbon\Carbon::parse($book->tanggal_terbit)->format('d M Y') }}
                                            </dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Dimensi</dt>
                                            <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $book->ukuran }}</dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Stok</dt>
                                            <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $book->stock ?? 0 }}</dd>
                                        </div>
                                    </div>

                                    <!-- Format Badges -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Format tersedia:</span>
                                        @if ($book->is_hard_available)
                                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                                 Hardcopy
                                            </span>
                                        @endif
                                        @if ($book->is_soft_available)
                                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400">
                                                 E-Book
                                            </span>
                                        @endif
                                        @if (!$book->is_hard_available && !$book->is_soft_available)
                                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-neutral-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400">
                                                Tidak tersedia
                                            </span>
                                        @endif
                                    </div>

                                    @if ($book->institusi)
                                        <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400 bg-neutral-50 dark:bg-neutral-800/50 px-4 py-2 rounded-lg">
                                            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span>{{ $book->institusi }}</span>
                                        </div>
                                    @endif

                                    @if ($book->keywords)
                                        <div class="space-y-2">
                                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Kata kunci:</span>
                                            <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $book->keywords }}</p>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- Price & Purchase Section -->
                        <div class="px-6 md:px-8 lg:px-10 pb-6 md:pb-8 lg:pb-10">
                            <div class="bg-gradient-to-br from-neutral-50 to-neutral-100 dark:from-neutral-800 dark:to-neutral-800/50 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                                
                                @if ($book->is_coming_soon)
                                    <!-- Coming Soon State -->
                                    <div class="text-center py-6">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-900/30 mb-4">
                                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-2">Coming Soon</h3>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Buku sedang dalam persiapan. Pantau terus untuk info rilis!</p>
                                    </div>
                                @else
                                    <!-- Price Display -->
                                    @php
                                        $hargaHardAsli = number_format($book->harga, 0, ',', '.');
                                        $hargaHardDiskon = number_format($book->harga_setelah_diskon, 0, ',', '.');
                                        $hargaSoftDiskonValue = $book->harga_soft_setelah_diskon ?? $book->harga_soft;
                                        $hargaSoftAsli = $book->harga_soft !== null ? number_format($book->harga_soft, 0, ',', '.') : null;
                                        $hargaSoftDiskon = $hargaSoftDiskonValue !== null ? number_format($hargaSoftDiskonValue, 0, ',', '.') : null;
                                    @endphp

                                    <div class="grid grid-cols-1 @if($book->is_hard_available && $book->is_soft_available) sm:grid-cols-2 @endif gap-4 mb-6">
                                        @if ($book->is_hard_available)
                                            <div class="bg-white dark:bg-neutral-900 rounded-lg p-5 border-2 border-emerald-200 dark:border-emerald-800">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                                         Hardcopy
                                                    </span>
                                                    @if (($book->diskon ?? 0) > 0)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                            -{{ $book->diskon }}%
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Rp</span>
                                                    <span class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $hargaHardDiskon }}</span>
                                                </div>
                                                @if (($book->diskon ?? 0) > 0)
                                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 line-through mt-1">
                                                        Rp {{ $hargaHardAsli }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif

                                        @if ($book->is_soft_available)
                                            <div class="bg-white dark:bg-neutral-900 rounded-lg p-5 border-2 border-sky-200 dark:border-sky-800">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-xs font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">
                                                         E-Book
                                                    </span>
                                                    @if (($book->diskon_soft ?? 0) > 0)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                            -{{ $book->diskon_soft }}%
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">Rp</span>
                                                    <span class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $hargaSoftDiskon ?? '-' }}</span>
                                                </div>
                                                @if (($book->diskon_soft ?? 0) > 0 && $hargaSoftAsli)
                                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 line-through mt-1">
                                                        Rp {{ $hargaSoftAsli }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="space-y-3">
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}"
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="group flex w-full items-center justify-center gap-3 rounded-lg bg-emerald-600 px-6 py-4 text-white font-semibold shadow-lg shadow-emerald-500/20 transition-all hover:bg-emerald-700 hover:shadow-xl hover:shadow-emerald-500/30 focus:outline-none focus:ring-4 focus:ring-emerald-500/50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.52 3.48A11.77 11.77 0 0 0 12 0 11.94 11.94 0 0 0 1.2 17.39L0 22.5l5.28-1.37A11.94 11.94 0 0 0 12 24h.01A11.98 11.98 0 0 0 24 12a11.9 11.9 0 0 0-3.48-8.52ZM12 21.6a9.6 9.6 0 0 1-4.9-1.33l-.35-.2-3.14.82.84-3.05-.22-.31a9.58 9.58 0 0 1-1.51-5.2c0-5.3 4.3-9.6 9.6-9.6A9.57 9.57 0 0 1 21.6 12c0 5.3-4.31 9.6-9.6 9.6Zm5.26-7.38c-.29-.15-1.7-.84-1.96-.93s-.46-.14-.65.14-.74.93-.9 1.12-.33.21-.62.06a7.87 7.87 0 0 1-2.32-1.43 8.7 8.7 0 0 1-1.61-2c-.17-.3 0-.46.13-.61.13-.13.3-.34.45-.51a2 2 0 0 0 .3-.5.55.55 0 0 0-.02-.52c-.06-.15-.64-1.55-.88-2.12s-.47-.49-.64-.5h-.55c-.17 0-.52.08-.8.37s-1.05 1.02-1.05 2.5 1.08 2.9 1.23 3.09 2.13 3.24 5.16 4.42a17.4 17.4 0 0 0 1.74.52 4.2 4.2 0 0 0 1.93.12c.59-.09 1.7-.7 1.94-1.38s.24-1.26.17-1.38-.26-.21-.55-.36Z"/>
                                            </svg>
                                            <span>Pesan via WhatsApp</span>
                                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>

                                        @if ($book->allow_umri_press_payment)
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'direct-purchase')"
                                                class="group flex w-full items-center justify-center gap-3 rounded-lg bg-cgreen-600 px-6 py-4 text-white font-semibold shadow-lg shadow-cgreen-500/20 transition-all hover:bg-cgreen-700 hover:shadow-xl hover:shadow-cgreen-500/30 focus:outline-none focus:ring-4 focus:ring-cgreen-500/50">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                <span>Beli via UMRI Press</span>
                                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                </svg>
                                            </button>
                                        @endif

                                        @if ($book->marketplace_links && $book->marketplace_links !== '[]')
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'marketplace-links')"
                                                class="group flex w-full items-center justify-center gap-3 rounded-lg border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-6 py-4 text-neutral-700 dark:text-neutral-300 font-semibold transition-all hover:border-cgreen-500 hover:bg-cgreen-50 hover:text-cgreen-700 dark:hover:border-cgreen-500 dark:hover:bg-cgreen-900/20 dark:hover:text-cgreen-400 focus:outline-none focus:ring-4 focus:ring-cgreen-500/30">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                <span>Lihat di Marketplace</span>
                                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tabs Section -->
                        <div class="border-t border-neutral-200 dark:border-neutral-700">
                            <div x-data="{ tab: 'description' }">
                                <!-- Tab Headers -->
                                <div class="flex overflow-x-auto border-b border-neutral-200 dark:border-neutral-700 px-6 md:px-8">
                                    <button @click="tab = 'description'"
                                        :class="{ 'border-cgreen-500 text-cgreen-600 dark:text-cgreen-400': tab === 'description' }"
                                        class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-neutral-600 hover:text-cgreen-600 dark:text-neutral-400 dark:hover:text-cgreen-400 transition-colors whitespace-nowrap">
                                        Abstrak
                                    </button>
                                    <button @click="tab = 'toc'"
                                        :class="{ 'border-cgreen-500 text-cgreen-600 dark:text-cgreen-400': tab === 'toc' }"
                                        class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-neutral-600 hover:text-cgreen-600 dark:text-neutral-400 dark:hover:text-cgreen-400 transition-colors whitespace-nowrap">
                                        Daftar Isi
                                    </button>
                                    <button @click="tab = 'synopsis'"
                                        :class="{ 'border-cgreen-500 text-cgreen-600 dark:text-cgreen-400': tab === 'synopsis' }"
                                        class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-neutral-600 hover:text-cgreen-600 dark:text-neutral-400 dark:hover:text-cgreen-400 transition-colors whitespace-nowrap">
                                        Daftar Pustaka
                                    </button>
                                    @if ($book->preview_pdf)
                                        <button @click="tab = 'preview'"
                                            :class="{ 'border-cgreen-500 text-cgreen-600 dark:text-cgreen-400': tab === 'preview' }"
                                            class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-neutral-600 hover:text-cgreen-600 dark:text-neutral-400 dark:hover:text-cgreen-400 transition-colors whitespace-nowrap">
                                            Preview
                                        </button>
                                    @endif
                                    <button @click="tab = 'komentar'"
                                        :class="{ 'border-cgreen-500 text-cgreen-600 dark:text-cgreen-400': tab === 'komentar' }"
                                        class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 border-transparent text-neutral-600 hover:text-cgreen-600 dark:text-neutral-400 dark:hover:text-cgreen-400 transition-colors whitespace-nowrap">
                                        Komentar
                                    </button>
                                </div>

                                <!-- Tab Contents -->
                                <div class="px-6 md:px-8 py-8">
                                    <div x-show="tab === 'description'" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-4"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="prose prose-neutral dark:prose-invert max-w-none">
                                        {!! $book->deskripsi !!}
                                    </div>
                                    
                                    <div x-show="tab === 'toc'" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-4"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="prose prose-neutral dark:prose-invert max-w-none">
                                        {!! $book->daftar_isi !!}
                                    </div>
                                    
                                    <div x-show="tab === 'synopsis'" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-4"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="prose prose-neutral dark:prose-invert max-w-none">
                                        {!! $book->sinopsis !!}
                                    </div>

                                    @if ($book->preview_pdf)
                                        <div x-show="tab === 'preview'"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 transform translate-y-4"
                                             x-transition:enter-end="opacity-100 transform translate-y-0"
                                             class="space-y-4">
                                            <p class="text-sm text-neutral-600 dark:text-neutral-300">
                                                Preview hanya menampilkan
                                                <span class="font-semibold">{{ $book->preview_pages ?? 5 }}</span>
                                                halaman. Untuk akses penuh, silakan lakukan pembelian.
                                            </p>
                                            @php
                                                $previewUrl = '/' . ltrim($book->preview_pdf, '/');
                                            @endphp
                                            <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900">
                                                <object data="{{ $previewUrl }}#page=1&view=FitH&zoom=page-fit"
                                                        type="application/pdf"
                                                        class="h-full w-full">
                                                    <iframe src="{{ $previewUrl }}"
                                                            class="h-full w-full"
                                                            title="Preview buku"></iframe>
                                                </object>
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Jika preview tidak muncul, <a href="{{ $previewUrl }}" target="_blank" class="text-cgreen-600 underline">buka di tab baru</a>.
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div x-show="tab === 'komentar'" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform translate-y-4"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-data="{ showCommentModal: false }">
                                        
                                        <div class="max-w-3xl mx-auto">
                                            <!-- Header -->
                                            <div class="flex items-center justify-between mb-6">
                                                <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                                                    Komentar
                                                </h2>
                                                <button type="button" 
                                                    @click="showCommentModal = true"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-cgreen-600 hover:bg-cgreen-700 text-white text-sm font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-cgreen-500 focus:ring-offset-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    <span>Tulis Komentar</span>
                                                </button>
                                            </div>

                                            <!-- Modal Form Komentar -->
                                            <div x-cloak 
                                                 x-show="showCommentModal"
                                                 x-transition.opacity.duration.200ms
                                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                                                <div @click.away="showCommentModal = false"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 scale-95"
                                                     x-transition:enter-end="opacity-100 scale-100"
                                                     class="bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                                                    
                                                    <div class="p-6">
                                                        <div class="flex items-center justify-between mb-6">
                                                            <h3 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                                                                Tulis Komentar
                                                            </h3>
                                                            <button @click="showCommentModal = false"
                                                                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <form method="POST" action="{{ route('buku.comment', $book->id) }}" class="space-y-4">
                                                            @csrf
                                                            <div>
                                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                                    Nama
                                                                </label>
                                                                <input type="text" 
                                                                       name="name"
                                                                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20 transition-colors"
                                                                       placeholder="Nama Anda" 
                                                                       required
                                                                       autocomplete="off">
                                                            </div>
                                                            
                                                            <div>
                                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                                    Email
                                                                </label>
                                                                <input type="email" 
                                                                       name="email"
                                                                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20 transition-colors"
                                                                       placeholder="email@contoh.com" 
                                                                       required
                                                                       autocomplete="off">
                                                            </div>
                                                            
                                                            <div>
                                                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                                    Komentar
                                                                </label>
                                                                <textarea name="content" 
                                                                          rows="4"
                                                                          class="w-full px-4 py-3 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20 transition-colors resize-none"
                                                                          placeholder="Tulis komentar Anda..." 
                                                                          required></textarea>
                                                            </div>
                                                            
                                                            <button type="submit"
                                                                class="w-full px-6 py-3 bg-cgreen-600 hover:bg-cgreen-700 text-white font-semibold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-cgreen-500 focus:ring-offset-2">
                                                                Kirim Komentar
                                                            </button>
                                                            
                                                            <p class="text-xs text-center text-neutral-500 dark:text-neutral-400">
                                                                Komentar akan ditampilkan setelah disetujui admin
                                                            </p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Daftar Komentar -->
                                            <div class="space-y-6">
                                                @forelse($comments as $comment)
                                                    <div class="bg-neutral-50 dark:bg-neutral-800/50 rounded-xl p-5 border border-neutral-200 dark:border-neutral-700">
                                                        <!-- Comment Header -->
                                                        <div class="flex items-start gap-4 mb-3">
                                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cgreen-400 to-cgreen-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="font-semibold text-neutral-900 dark:text-neutral-100">
                                                                    {{ $comment->name }}
                                                                </div>
                                                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                                    {{ $comment->created_at->diffForHumans() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Comment Content -->
                                                        <div class="text-neutral-700 dark:text-neutral-300 mb-3 pl-14">
                                                            {!! nl2br(e($comment->content)) !!}
                                                        </div>
                                                        
                                                        <!-- Reply Button -->
                                                        <div class="pl-14">
                                                            <button type="button"
                                                                class="text-sm font-medium text-cgreen-600 dark:text-cgreen-400 hover:text-cgreen-700 dark:hover:text-cgreen-300 reply-btn"
                                                                data-id="{{ $comment->id }}">
                                                                 Balas
                                                            </button>
                                                        </div>

                                                        <!-- Form Reply -->
                                                        <form method="POST"
                                                            action="{{ route('buku.comment.reply', [$book->id, $comment->id]) }}"
                                                            class="reply-form mt-4 pl-14 hidden">
                                                            @csrf
                                                            <div class="space-y-3 bg-white dark:bg-neutral-900 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                                                <input type="text" 
                                                                       name="name"
                                                                       class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20"
                                                                       placeholder="Nama Anda" 
                                                                       required
                                                                       autocomplete="off">
                                                                
                                                                <input type="email" 
                                                                       name="email"
                                                                       class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20"
                                                                       placeholder="Email Anda" 
                                                                       required
                                                                       autocomplete="off">
                                                                
                                                                <textarea name="content" 
                                                                          rows="3"
                                                                          class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-500/20 resize-none"
                                                                          placeholder="Tulis balasan..." 
                                                                          required></textarea>
                                                                
                                                                <button type="submit"
                                                                    class="px-4 py-2 bg-cgreen-600 hover:bg-cgreen-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                                                    Kirim Balasan
                                                                </button>
                                                            </div>
                                                        </form>

                                                        <!-- Replies -->
                                                        @if ($comment->replies->count())
                                                            <div class="mt-4 pl-14 space-y-4 border-l-2 border-cgreen-200 dark:border-cgreen-800 ml-5">
                                                                @foreach ($comment->replies as $reply)
                                                                    @if ($reply->is_approved)
                                                                        <div class="pl-4 bg-white dark:bg-neutral-900 rounded-lg p-4 border border-neutral-200 dark:border-neutral-700">
                                                                            <div class="flex items-start gap-3 mb-2">
                                                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-neutral-300 to-neutral-400 dark:from-neutral-600 dark:to-neutral-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                                                    {{ strtoupper(substr($reply->name, 0, 1)) }}
                                                                                </div>
                                                                                <div class="flex-1 min-w-0">
                                                                                    <div class="font-semibold text-neutral-900 dark:text-neutral-100 text-sm">
                                                                                        {{ $reply->name }}
                                                                                    </div>
                                                                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                                                        {{ $reply->created_at->diffForHumans() }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-sm text-neutral-700 dark:text-neutral-300 pl-11">
                                                                                {!! nl2br(e($reply->content)) !!}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div class="text-center py-12">
                                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 dark:bg-neutral-800 mb-4">
                                                            <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                        </div>
                                                        <p class="text-neutral-500 dark:text-neutral-400 font-medium">Belum ada komentar</p>
                                                        <p class="text-sm text-neutral-400 dark:text-neutral-500 mt-1">Jadilah yang pertama berkomentar!</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Penulis -->
                        <div class="p-6 md:p-8 border-t border-neutral-200 dark:border-neutral-700">
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 mb-6">Tentang Penulis</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($book->authors as $author)
                                    <a href="{{ route('author', $author->slug) }}"
                                       wire:navigate
                                       class="group flex items-center gap-4 p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:border-cgreen-500 dark:hover:border-cgreen-500 transition-all hover:shadow-md">
                                        <img src="{{ asset($author->image) }}"
                                            alt="{{ $author->name }}"
                                            class="w-16 h-16 rounded-full object-cover ring-2 ring-neutral-200 dark:ring-neutral-700 group-hover:ring-cgreen-500 transition-all flex-shrink-0" 
                                            loading="lazy">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-neutral-900 dark:text-neutral-100 group-hover:text-cgreen-600 dark:group-hover:text-cgreen-400 transition-colors line-clamp-1">
                                                {{ $author->name }}
                                            </h3>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-2">
                                                @php
                                                    $deskripsi = strip_tags($author->description);
                                                    echo Str::limit($deskripsi, 80);
                                                @endphp
                                            </p>
                                        </div>
                                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-cgreen-500 transition-all group-hover:translate-x-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Related Books -->
                <aside class="w-full lg:w-1/4">
                    <div class="lg:sticky lg:top-6 space-y-6">
                        <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 shadow-sm border border-neutral-100 dark:border-neutral-800">
                            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cgreen-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Buku Terkait
                            </h2>

                            <div class="space-y-4">
                                @forelse($relatedBooks as $relatedBook)
                                    <a href="{{ route('detailBuku', $relatedBook->slug) }}" 
                                       wire:navigate
                                       class="group block">
                                        <div class="flex gap-3 p-3 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:border-cgreen-500 dark:hover:border-cgreen-500 transition-all hover:shadow-md">
                                            <div class="w-16 aspect-[2/3] rounded-md overflow-hidden flex-shrink-0 ring-1 ring-neutral-200 dark:ring-neutral-700">
                                                <img src="{{ asset($relatedBook->cover_thumbnail) }}"
                                                    alt="{{ $relatedBook->judul }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                                                    loading="lazy" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 line-clamp-2 group-hover:text-cgreen-600 dark:group-hover:text-cgreen-400 transition-colors mb-1">
                                                    {{ $relatedBook->judul }}
                                                </h3>
                                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">
                                                    {{ $relatedBook->authors->first()->name }}
                                                </p>
                                                <div class="flex items-center gap-2">
                                                    @if ($relatedBook->is_coming_soon)
                                                        <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">Coming Soon</span>
                                                    @else
                                                        <span class="text-sm font-bold text-cgreen-600 dark:text-cgreen-400">
                                                            Rp {{ number_format($relatedBook->harga_setelah_diskon, 0, ',', '.') }}
                                                        </span>
                                                        @if ($relatedBook->diskon > 0)
                                                            <span class="text-xs text-neutral-400 line-through">
                                                                Rp {{ number_format($relatedBook->harga, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-neutral-300 dark:text-neutral-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Tidak ada buku terkait</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Modals -->
            @if ($book->allow_umri_press_payment && !$book->is_coming_soon)
                <x-modal name="direct-purchase" :show="false" maxWidth="3xl">
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-50">
                                    Beli Langsung via UMRI Press
                                </h3>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                    Lengkapi form berikut untuk melakukan pemesanan buku
                                </p>
                            </div>
                            <button x-on:click="$dispatch('close')" 
                                    class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <livewire:home.beli-langsung :book="$book" />
                    </div>
                </x-modal>
            @endif

            @if ($book->marketplace_links && $book->marketplace_links !== '[]')
                <x-modal name="marketplace-links" :show="$errors->isNotEmpty()" focusable align="center" maxWidth="md">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">
                                Beli di Marketplace
                            </h3>
                            <button x-on:click="$dispatch('close')" 
                                    class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">Pilih marketplace untuk membeli buku ini</p>
                        
                        <div class="space-y-3">
                            @foreach (json_decode($book->marketplace_links, true) as $marketplace => $link)
                                <a href="{{ $link }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="group flex items-center justify-between p-4 rounded-lg border-2 border-neutral-200 dark:border-neutral-700 hover:border-cgreen-500 dark:hover:border-cgreen-500 bg-white dark:bg-neutral-800 transition-all hover:shadow-md">
                                    <span class="font-medium text-neutral-900 dark:text-neutral-100 capitalize">
                                        🛒 {{ $marketplace }}
                                    </span>
                                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-cgreen-500 transition-all group-hover:translate-x-1" 
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </x-modal>
            @endif
        </x-container>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Reply button functionality
            document.querySelectorAll('.reply-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('.bg-neutral-50, .bg-neutral-800\\/50').querySelector('.reply-form');
                    if (form) {
                        form.classList.toggle('hidden');
                    }
                });
            });
        });
    </script>
</x-main-layout>
