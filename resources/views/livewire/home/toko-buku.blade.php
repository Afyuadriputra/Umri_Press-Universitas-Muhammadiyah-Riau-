<div class="container mx-auto px-4 py-12 max-w-7xl">
    
{{-- Search & Sort Header Wrapper --}}
<div class="mb-10 flex flex-col md:flex-row gap-4 items-center justify-between">
    
    {{-- 1. Search Bar Container --}}
    <div class="relative w-full md:flex-1 group z-10">
        <div class="relative flex items-center">
            
            {{-- Search Icon (Left) - Berubah warna saat fokus --}}
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-20">
                <svg class="h-5 w-5 text-neutral-400 group-focus-within:text-cgreen-500 transition-colors duration-300" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            {{-- Input Field --}}
            <input type="text" 
                   wire:model.live.debounce.300ms="search"
                   class="w-full pl-12 pr-20 py-3.5 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-neutral-800 dark:text-neutral-100 placeholder-neutral-400 focus:outline-none focus:border-cgreen-500 focus:ring-4 focus:ring-cgreen-500/10 transition-all duration-300 shadow-sm peer"
                   placeholder="Cari judul, ISBN, atau tahun terbit (contoh: 2024)">

            {{-- Right Side Actions (Clear & Loading) --}}
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 gap-2">
                
                {{-- Clear Button (Hanya muncul jika ada ketikan) --}}
                @if(!empty($search))
                    <button wire:click="$set('search', '')" 
                            class="p-1 rounded-full text-neutral-400 hover:bg-neutral-100 hover:text-red-500 dark:hover:bg-neutral-700 transition-colors"
                            title="Hapus pencarian">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif

                {{-- Loading Spinner (Muncul saat Livewire memproses) --}}
                <div wire:loading wire:target="search">
                    <svg class="animate-spin h-5 w-5 text-cgreen-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Sort Dropdown --}}
    <div class="relative w-full md:w-64 group">
        {{-- Custom Select Icon (Left) --}}
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-neutral-400 group-focus-within:text-cgreen-500 transition-colors duration-300" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
            </svg>
        </div>

        {{-- Select Element --}}
        <select wire:model.live="sortBy"
                class="w-full pl-12 pr-10 py-3.5 appearance-none bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-neutral-800 dark:text-neutral-100 focus:outline-none focus:border-cgreen-500 focus:ring-4 focus:ring-cgreen-500/10 cursor-pointer transition-all duration-300 shadow-sm truncate">
            <option value="newest">Terbaru</option>
            <option value="price_low">Harga Terendah</option>
            <option value="price_high">Harga Tertinggi</option>
            <option value="title_asc">Judul (A-Z)</option>
            <option value="title_desc">Judul (Z-A)</option>
        </select>

        {{-- Custom Chevron Arrow (Right) --}}
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-neutral-400 group-focus-within:text-cgreen-500 transition-colors duration-300" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    {{-- 3. Year Picker --}}
    <div class="relative w-full md:w-48 group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-neutral-400 group-focus-within:text-cgreen-500 transition-colors duration-300"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <input type="month"
               wire:model.live="year"
               class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-neutral-800 dark:text-neutral-100 placeholder-neutral-400 focus:outline-none focus:border-cgreen-500 focus:ring-4 focus:ring-cgreen-500/10 transition-all duration-300 shadow-sm"
               placeholder="Tahun terbit">
    </div>
</div>

    {{-- Book Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-10">
        @forelse($books as $book)
            <div class="group flex flex-col h-full">
                {{-- Card Container --}}
                <div class="relative bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-neutral-200/50 dark:hover:shadow-black/50 border border-neutral-100 dark:border-neutral-700/50 flex-1 flex flex-col">
                    
                    {{-- Cover Image & Overlay --}}
                    <div class="relative aspect-[2/3] overflow-hidden bg-neutral-100 dark:bg-neutral-900">
                        <img src="{{ asset($book->cover_thumbnail) }}" alt="{{ $book->judul }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out" loading="lazy">
                        
                        {{-- Discount Badge --}}
                        @if (!$book->is_coming_soon && $book->diskon > 0)
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] md:text-xs font-bold px-3 py-1.5 rounded-bl-xl shadow-sm z-10">
                                -{{ $book->diskon }}%
                            </span>
                        @endif

                        {{-- Hover Overlay Action --}}
                        <div class="absolute inset-0 bg-neutral-900/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ route('detailBuku', $book->slug) }}" wire:navigate
                                class="translate-y-4 group-hover:translate-y-0 transition-transform duration-300 bg-white text-neutral-900 hover:bg-cgreen-500 hover:text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg tracking-wide">
                                Lihat Detail
                            </a>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Title --}}
                        <div class="mb-3 min-h-[3rem]">
                            <h3 class="font-bold text-base leading-tight text-neutral-800 dark:text-neutral-100 line-clamp-2 group-hover:text-cgreen-600 dark:group-hover:text-cgreen-400 transition-colors duration-200">
                                {{ $book->judul }}
                            </h3>
                        </div>

                        {{-- Metadata --}}
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <div class="h-1 w-1 rounded-full bg-neutral-300 dark:bg-neutral-600"></div>
                            <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                {{ $book->jumlah_halaman }} Hal
                            </p>
                            <div class="h-1 w-1 rounded-full bg-neutral-300 dark:bg-neutral-600"></div>
                            <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Stok: {{ $book->stock ?? 0 }}
                            </p>
                            <div class="h-1 w-1 rounded-full bg-neutral-300 dark:bg-neutral-600"></div>
                            <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Terbit: {{ \Carbon\Carbon::parse($book->tanggal_terbit)->format('Y') }}
                            </p>
                        </div>
                        @if ($book->preview_pdf)
                            <div class="mb-3">
                                <span class="inline-flex items-center gap-2 rounded-full border border-cgreen-100 bg-cgreen-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-wider text-cgreen-700 dark:border-cgreen-900/30 dark:bg-cgreen-900/10 dark:text-cgreen-300">
                                    Preview {{ $book->preview_pages ?? 5 }} Hal
                                </span>
                            </div>
                        @endif
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if ($book->is_hard_available)
                                <span class="inline-flex items-center rounded-full border border-neutral-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-neutral-700 shadow-sm dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                                    Hardfile
                                </span>
                            @endif
                            @if ($book->is_soft_available)
                                <span class="inline-flex items-center rounded-full border border-neutral-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-neutral-700 shadow-sm dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                                    Softfile
                                </span>
                            @endif
                            @if (!$book->is_hard_available && !$book->is_soft_available)
                                <span class="inline-flex items-center rounded-full border border-neutral-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-neutral-500 shadow-sm dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
                                    Tidak tersedia
                                </span>
                            @endif
                        </div>

                        {{-- Price Section (Pushed to bottom) --}}
                        <div class="mt-auto pt-4 border-t border-dashed border-neutral-200 dark:border-neutral-700 flex justify-between items-end">
                            <div class="flex flex-col gap-2">
                                @if ($book->is_coming_soon)
                                    <span class="text-xs text-transparent select-none mb-0.5">.</span>
                                    <span class="text-lg font-bold text-amber-600 dark:text-amber-400">Coming Soon</span>
                                @else
                                    @php
                                        $hargaHardAsli = number_format($book->harga, 0, ',', '.');
                                        $hargaHardDiskon = number_format($book->harga_setelah_diskon, 0, ',', '.');
                                        $hargaSoftDiskonValue = $book->harga_soft_setelah_diskon ?? $book->harga_soft;
                                        $hargaSoftAsli = $book->harga_soft !== null ? number_format($book->harga_soft, 0, ',', '.') : null;
                                        $hargaSoftDiskon = $hargaSoftDiskonValue !== null ? number_format($hargaSoftDiskonValue, 0, ',', '.') : null;
                                    @endphp
                                    @if ($book->is_hard_available)
                                        <div class="flex items-center justify-between gap-2 rounded-lg border border-neutral-100 bg-neutral-50 px-2.5 py-1.5 dark:border-neutral-700 dark:bg-neutral-800/60">
                                            <span class="text-[10px] font-semibold uppercase tracking-wider text-neutral-400">Hardfile</span>
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-sm font-bold text-neutral-900 dark:text-white">Rp {{ $hargaHardDiskon }}</span>
                                                @if (($book->diskon ?? 0) > 0)
                                                    <span class="text-[10px] text-neutral-400 line-through">Rp {{ $hargaHardAsli }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if ($book->is_soft_available)
                                        <div class="flex items-center justify-between gap-2 rounded-lg border border-neutral-100 bg-neutral-50 px-2.5 py-1.5 dark:border-neutral-700 dark:bg-neutral-800/60">
                                            <span class="text-[10px] font-semibold uppercase tracking-wider text-neutral-400">Softfile</span>
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-sm font-bold text-neutral-900 dark:text-white">Rp {{ $hargaSoftDiskon ?? '-' }}</span>
                                                @if (($book->diskon_soft ?? 0) > 0 && $hargaSoftAsli)
                                                    <span class="text-[10px] text-neutral-400 line-through">Rp {{ $hargaSoftAsli }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            
                            {{-- Secondary Action --}}
                            <a href="{{ route('detailBuku', $book->slug) }}" wire:navigate
                                class="text-cgreen-600 dark:text-cgreen-400 hover:text-cgreen-700 dark:hover:text-cgreen-300 p-2 -mr-2 rounded-full hover:bg-cgreen-50 dark:hover:bg-neutral-700/50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                <div class="bg-neutral-50 dark:bg-neutral-800 p-6 rounded-full mb-4">
                    <svg class="h-10 w-10 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Belum ada buku</h3>
                <p class="text-neutral-500 dark:text-neutral-400 mt-1 max-w-sm mx-auto">Coba cari dengan kata kunci lain atau ubah filter pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    @if ($books->hasPages())
        <div class="mt-12 border-t border-neutral-200 dark:border-neutral-800 pt-8">
            {{ $books->links() }}
        </div>
    @endif

    {{-- Modal Component --}}
    <x-modal name="marketplacesModal" :show="false" maxWidth="md">
        <div class="relative bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-2xl">
            
            {{-- Modal Header --}}
            <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700 flex items-center justify-between bg-neutral-50/50 dark:bg-neutral-900/50 backdrop-blur-sm">
                <div>
                    <span class="block text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-0.5">Beli Buku</span>
                    <h2 class="text-lg font-bold text-neutral-800 dark:text-neutral-100 line-clamp-1">
                        {{ $selectedBook?->judul }}
                    </h2>
                </div>
                <button x-on:click="$dispatch('close')" class="p-2 rounded-full text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                {{-- Internal Purchase Option --}}
                @if ($selectedBook?->allow_umri_press_payment && !$selectedBook?->is_coming_soon)
                    <a href="{{ route('detailBuku', $selectedBook?->slug) }}#beli-langsung"
                        class="group flex items-center justify-between w-full p-4 rounded-xl border border-cgreen-200 bg-cgreen-50/50 hover:bg-cgreen-50 hover:border-cgreen-500 transition-all duration-200 dark:bg-cgreen-900/10 dark:border-cgreen-900/30 dark:hover:border-cgreen-500/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-cgreen-100 dark:bg-cgreen-900/40 rounded-lg text-cgreen-600 dark:text-cgreen-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-bold text-cgreen-700 dark:text-cgreen-400">UMRI Press</span>
                                <span class="block text-xs text-cgreen-600/80 dark:text-cgreen-500/80">Beli langsung via website</span>
                            </div>
                        </div>
                        <svg class="h-4 w-4 text-cgreen-400 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
                
                {{-- Divider Text --}}
                @if($selectedBook?->allow_umri_press_payment && !empty($marketplaceLinks))
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-neutral-200 dark:border-neutral-700"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white dark:bg-neutral-800 px-2 text-xs text-neutral-400 uppercase tracking-widest">Atau via Marketplace</span>
                        </div>
                    </div>
                @endif

                {{-- Marketplace Links --}}
                @if (!empty($marketplaceLinks))
                    <div class="space-y-3">
                        @foreach (($marketplaceLinks ?? []) as $marketplace => $link)
                            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                               class="group flex items-center justify-between w-full p-3.5 rounded-xl border border-neutral-100 bg-white hover:border-neutral-300 hover:shadow-md hover:shadow-neutral-100 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:border-neutral-500 dark:hover:bg-neutral-750 transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    {{-- Placeholder Icon for Marketplaces --}}
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-neutral-100 dark:bg-neutral-700 text-neutral-500 font-bold uppercase text-xs">
                                        {{ substr($marketplace, 0, 1) }}
                                    </div>
                                    <span class="text-base font-medium text-neutral-700 dark:text-neutral-200 capitalize group-hover:text-neutral-900 dark:group-hover:text-white transition-colors">
                                        {{ $marketplace }}
                                    </span>
                                </div>
                                <svg class="h-4 w-4 text-neutral-400 group-hover:text-cgreen-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                @else
                    @if (!$selectedBook?->allow_umri_press_payment)
                        <div class="text-center py-6 bg-neutral-50 dark:bg-neutral-900/50 rounded-xl border border-dashed border-neutral-200 dark:border-neutral-700">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">Belum ada opsi pembelian tersedia.</p>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Footer --}}
            <div class="bg-neutral-50 dark:bg-neutral-900/30 px-6 py-4 flex justify-between items-center">
                 <p class="text-xs text-neutral-400">Link terbuka di tab baru</p>
                 <button x-on:click="$dispatch('close')" class="text-sm font-semibold text-neutral-600 hover:text-neutral-800 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors">
                    Tutup
                 </button>
            </div>
        </div>
    </x-modal>
</div>
