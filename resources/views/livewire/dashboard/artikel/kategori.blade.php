<div class="p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Manajemen Kategori Artikel</h2>
        <x-primary-button wire:click="openCreateModal" class="!inline-flex items-center gap-2 !w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </x-primary-button>
    </div>

    <!-- Search Box -->
    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex gap-4 items-center">
            <div class="flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Kategori
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan nama..." />
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Nama
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Slug
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Total Artikel
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $category->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $category->artikel_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-3">
                                    <button wire:click="edit({{ $category->id }})"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})"
                                        class="text-cgreen-600 hover:text-cgreen-900 dark:text-cgreen-400 dark:hover:text-cgreen-300">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                Tidak ada kategori yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Category Modal -->
    <x-modal name="categoryModal" :show="false" maxWidth="md" align="center">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                {{ $editingCategoryId ? 'Edit Kategori' : 'Tambah Kategori' }}
            </h2>

            <div class="space-y-4">
                <div>
                    <x-input-label class="block mb-2">Nama Kategori</x-input-label>
                    <x-text-input type="text" wire:model.live="name" class="w-full block" placeholder="Nama kategori" />
                    @error('name')
                        <span class="text-cgreen-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">Slug</x-input-label>
                    <x-text-input type="text" wire:model="slug" class="w-full block bg-neutral-100 dark:bg-neutral-800"
                        readonly />
                    @error('slug')
                        <span class="text-cgreen-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button x-on:click="$dispatch('close')" class="!w-auto">
                    Batal
                </x-border-button>
                <x-primary-button wire:click="save" class="!w-auto">
                    {{ $editingCategoryId ? 'Simpan Perubahan' : 'Simpan' }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirmDelete" :show="false" align="center" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button x-on:click="$dispatch('close')" class="!w-auto">
                    Batal
                </x-border-button>
                <x-primary-button wire:click="delete" class="!w-auto">
                    Hapus Kategori
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>