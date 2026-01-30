<div class="p-6">
    @include('components.alert')

    <div class="flex flex-wrap justify-end mb-4 gap-3">
        <a href="{{ route('tempatSampahArtikel') }}" wire:navigate>
            <x-border-button class="!inline-flex items-center gap-2 !w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Tempat Sampah {{ $trashCount > 0 ? '(' . $trashCount . ')' : '' }}
            </x-border-button>
        </a>
        <a href="{{ route('tambahArtikel') }}" wire:navigate>
            <x-primary-button class="!inline-flex items-center gap-2 !w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Artikel
            </x-primary-button>
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Artikel
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan judul..." />
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
                </select>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Status
                </label>
                <select wire:model.live="status"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="">Semua Status</option>
                    <option value="publish">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Gambar
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Informasi Artikel
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($articles as $article)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-24 h-16 object-cover rounded-lg shadow-sm">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $article->judul }}
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $article->created_at->format('d M Y') }}
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    Oleh: {{ $article->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    bg-cgreen-100 text-cgreen-800 dark:bg-cgreen-800/20 dark:text-cgreen-400">
                                    {{ $article->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click='changeStatus("{{ $article->slug }}")'
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $article->status === 'publish'
                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400' }}">
                                    {{ $article->status === 'publish' ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button wire:click="showDetail('{{ $article->slug }}')"
                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        Detail
                                    </button>
                                    <a href="{{ route('editArtikel', $article->slug) }}" wire:navigate>
                                        <button
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Edit
                                        </button>
                                    </a>
                                    <button wire:click="confirmDelete({{ $article->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                Tidak ada artikel yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirmDelete" :show="false" maxWidth="md" align="center">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="delete" wire:loading.attr="disabled">
                    Hapus Artikel
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Detail Modal -->
    <x-modal name="detailModal" :show="false" maxWidth="4xl">
        <div class="p-6">
            @if ($selectedArticle)
                <div class="flex flex-col gap-6">
                    <!-- Article Image -->
                    <div class="w-full">
                        <img src="{{ asset($selectedArticle->image) }}" alt="{{ $selectedArticle->judul }}"
                            class="w-full rounded-lg shadow-lg">
                    </div>

                    <!-- Article Details -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                            {{ $selectedArticle->judul }}
                        </h2>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Status:</span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $selectedArticle->status === 'publish'
                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400' }}">
                                    {{ $selectedArticle->status === 'publish' ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Penulis:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">{{ $selectedArticle->user->name }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Kategori:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">{{ $selectedArticle->kategori->nama }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">Tanggal Publish:</span>
                                <span class="text-neutral-900 dark:text-neutral-100">
                                    {{ $selectedArticle->created_at->format('d F Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Konten</h3>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $selectedArticle->konten !!}
                            </div>
                        </div>
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