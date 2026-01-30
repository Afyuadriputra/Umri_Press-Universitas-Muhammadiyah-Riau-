<div class="p-6">
    @include('components.alert')

    <div class="flex flex-wrap justify-end mb-4 gap-3">
        <a href="{{ route('tempatSampah') }}" wire:navigate>
            <x-border-button class="!inline-flex items-center gap-2 !w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>

                Tempat Sampah {{ $trashCount > 0 ? '(' . $trashCount . ')' : '' }}
            </x-border-button>
        </a>
        <a href="{{ route('tambahBuku') }}" wire:navigate>
            <x-primary-button class="!inline-flex items-center gap-2 !w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

                Tambah Buku
            </x-primary-button>
        </a>
    </div>
    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Buku
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan judul atau ISBN..." />
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Urutkan
                </label>
                <select wire:model.live="sortBy"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="title_asc">Judul A-Z</option>
                    <option value="title_desc">Judul Z-A</option>
                    <option value="price_low">Harga Terendah</option>
                    <option value="price_high">Harga Tertinggi</option>
                </select>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Status
                </label>
                <select wire:model.live="status"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Cover
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Informasi Buku
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Harga
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($books as $book)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-start gap-4">
                                    <img src="{{ asset($book->cover_thumbnail) }}" alt="{{ $book->title }}"
                                        class="w-16 h-24 object-cover rounded-lg shadow-sm">
                                    <div class="md:hidden space-y-1">
                                        <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 capitalize">
                                            {{ $book->judul }}
                                        </div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                            ISBN: {{ $book->isbn }}
                                        </div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ $book->jumlah_halaman }} Halaman
                                        </div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                            Stok: {{ $book->stock ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="space-y-1">
                                    <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 capitalize">
                                        {{ $book->judul }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        ISBN: {{ $book->isbn }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $book->jumlah_halaman }} Halaman
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        Stok: {{ $book->stock ?? 0 }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                        Royalti:
                                        @if ($book->authors->isEmpty())
                                            -
                                        @else
                                            @foreach ($book->authors as $author)
                                                <span class="whitespace-nowrap">
                                                    {{ $author->name }} ({{ number_format($author->pivot->royalty_percentage ?? 0, 2) }}%)
                                                </span>@if (! $loop->last),@endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-1">
                                    @if ($book->is_coming_soon)
                                        <span class="text-sm font-semibold text-amber-600 dark:text-amber-400">Coming Soon</span>
                                    @else
                                        <span class="text-sm font-semibold text-cgreen-500 dark:text-cgreen-400">
                                            Rp {{ number_format($book->harga_setelah_diskon, 0, ',', '.') }}
                                        </span>
                                        @if ($book->diskon > 0)
                                            <span class="text-xs text-red-500 line-through">
                                                Rp {{ number_format($book->harga, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <button wire:click='changeStatus("{{ $book->slug }}")'
                                    class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                                    {{ $book->status === 1
                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                        : 'bg-cgreen-100 text-cgreen-800 dark:bg-cgreen-800/20 dark:text-cgreen-400' }}">
                                    {{ $book->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 align-top text-sm">
                                <div class="flex flex-wrap gap-2">
                                    <button wire:click="showDetail('{{ $book->slug }}')"
                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        Detail
                                    </button>
                                    <a href="{{ route('editBuku', $book->slug) }}" wire:navigate
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                    <button wire:click="confirmDelete({{ $book->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                Tidak ada data buku yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $books->links() }}
        </div>
    </div>

    <x-modal name="confirmDelete" :show="false" maxWidth="md" align="center">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="delete" wire:loading.attr="disabled">
                    Hapus Buku
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="detailModal" :show="false" maxWidth="7xl" align="center">
        <div class="p-6">
            @if ($selectedBook)
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Book Cover -->
                    <div class="w-full md:w-1/4">
                        <img src="{{ asset($selectedBook->cover) }}" alt="{{ $selectedBook->judul }}"
                            class="w-full h-auto rounded-lg shadow-lg">
                    </div>

                    <!-- Book Information -->
                    <div class="w-full md:w-3/4 space-y-4">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                            {{ $selectedBook->judul }}
                        </h2>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Status:</span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $selectedBook->status === 1
                                    ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                    : 'bg-cgreen-100 text-cgreen-800 dark:bg-cgreen-800/20 dark:text-cgreen-400' }}">
                                    {{ $selectedBook->status === 1 ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Ketersediaan:</span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $selectedBook->ketersediaan === 1
                                    ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                    : 'bg-cgreen-100 text-cgreen-800 dark:bg-cgreen-800/20 dark:text-cgreen-400' }}">
                                    {{ $selectedBook->ketersediaan === 1 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Penulis:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">
                                    @php

                                        $authors = explode(',', $selectedBook->authors->pluck('name')->implode(', '));

                                        foreach ($authors as $i => $author) {
                                            if ($i < count($authors) - 1) {
                                                echo $author . ', ';
                                            } else {
                                                echo $author;
                                            }
                                        }

                                    @endphp
                                </span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Royalti:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">
                                    @if ($selectedBook->authors->isEmpty())
                                        -
                                    @else
                                        @foreach ($selectedBook->authors as $author)
                                            <span class="whitespace-nowrap">
                                                {{ $author->name }} ({{ number_format($author->pivot->royalty_percentage ?? 0, 2) }}%)
                                            </span>@if (! $loop->last),@endif
                                        @endforeach
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">ISBN:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">{{ $selectedBook->isbn }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Keyword:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">{{ $selectedBook->keywords ?? '-' }}</span>
                            </div>
                              <div>
                                  <span class="text-neutral-500 dark:text-neutral-400">Harga:</span>
                                  <div class="mt-1 flex items-baseline gap-3 text-cgreen-500 dark:text-cgreen-400">
                                    @if ($selectedBook->is_coming_soon)
                                        <span class="text-lg font-semibold text-amber-600 dark:text-amber-400">Coming Soon</span>
                                    @else
                                        <span class="text-lg font-semibold">
                                            Rp {{ number_format($selectedBook->harga_setelah_diskon, 0, ',', '.') }}
                                        </span>
                                        @if ($selectedBook->diskon > 0)
                                            <span class="text-sm text-red-500 line-through font-semibold">
                                                Rp {{ number_format($selectedBook->harga, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    @endif
                                  </div>
                              </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Institusi:</span>
                                <span
                                    class="text-neutral-900 dark:text-neutral-100">{{ $selectedBook->institusi ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Jumlah Halaman:</span>
                                <span
                                    class="text-neutral-900 dark:text-neutral-100">{{ $selectedBook->jumlah_halaman }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Stok:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">{{ $selectedBook->stock ?? 0 }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Tanggal Terbit:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">
                                    {{ \Carbon\Carbon::parse($selectedBook->tanggal_terbit)->format('d F Y') }}
                                </span>
                            </div>

                        </div>

                        <!-- Abstrack -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Abstrack</h3>
                            <div
                                class="text-sm text-neutral-600 dark:text-neutral-300 prose dark:prose-invert max-w-none">
                                {!! $selectedBook->deskripsi !!}
                            </div>
                        </div>

                        <!-- Daftar Pustaka -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Daftar Pustaka</h3>
                            <div
                                class="text-sm text-neutral-600 dark:text-neutral-300 prose dark:prose-invert max-w-none">
                                {!! $selectedBook->sinopsis !!}
                            </div>
                        </div>

                        <!-- Marketplace Links -->
                        @if ($selectedBook->marketplace_links)
                            <div class="space-y-2">
                                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                                    Link Marketplace
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (json_decode($selectedBook->marketplace_links, true) as $marketplace => $link)
                                        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                            bg-neutral-100 text-neutral-700 hover:bg-neutral-200
                                            dark:bg-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-600">
                                            <span class="capitalize">{{ $marketplace }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 ml-1">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-border-button @click="$dispatch('close')" class="!w-auto">
                        Tutup
                    </x-border-button>
                </div>
            @endif
        </div>
    </x-modal>
</div>
