<div class="p-6">
    @include('components.alert')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Daftar Penulis</h2>
        <div class="flex flex-wrap gap-3">
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'authorModal')"
                wire:click="resetForm" class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Penulis
            </x-primary-button>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Penulis
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan nama..." />
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Urutkan
                </label>
                <select wire:model.live="sortBy"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Authors Table -->
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
                            Nama
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Akun
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Jumlah Buku
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($authors as $author)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <img src="{{ asset($author->image) }}" alt="Gambar Penulis"
                                class="w-12 h-12 rounded-full object-cover" loading="lazy">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100 capitalize">
                                {{ $author->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-neutral-500 dark:text-neutral-400 line-clamp-2">
                                {{ $author->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $author->user?->email ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $author->buku_count }} Buku
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'authorModal')"
                                    wire:click="edit({{ $author->id }})"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </button>
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'showDeleteModal')"
                                    wire:click="confirmDelete({{ $author->id }})"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                            Tidak ada data penulis
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $authors->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-modal name="authorModal" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                {{ $authorId ? 'Edit Penulis' : 'Tambah Penulis' }}
            </h3>

            <form wire:submit.prevent="{{ $authorId ? 'update' : 'save' }}" class="space-y-4">
                <div>
                    @if ($image)
                    <div class="mb-2">
                        <img src="{{ $image->temporaryUrl() }}" alt="Gambar Penulis"
                            class="w-24 h-24 rounded-lg object-cover">
                    </div>
                    @elseif ($imagePreview)
                    <div class="mb-2">
                        <img src="{{ asset($imagePreview) }}" alt="Gambar Penulis"
                            class="w-24 h-24 rounded-lg object-cover">
                    </div>
                    @endif

                    <x-input-label>Gambar <span class="text-red-500">*</span></x-input-label>
                    <x-text-input type="file" wire:model="image" class="w-full mt-1" />
                    @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label>Nama <span class="text-red-500">*</span></x-input-label>
                    <x-text-input type="text" wire:model="name" class="w-full mt-1" />
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label>Deskripsi <span class="text-red-500">*</span></x-input-label>
                    <textarea wire:model="description"
                        class="w-full mt-1 rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500"
                        rows="4"></textarea>
                    @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label>Akun Penulis (opsional)</x-input-label>
                    <select wire:model="user_id"
                        class="w-full mt-1 rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                        <option value="">-- Pilih akun --</option>
                        @foreach ($authorUsers as $user)
                            <option value="{{ $user['id'] }}">
                                {{ $user['name'] }} ({{ $user['email'] }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <x-border-button type="button" x-on:click="$dispatch('close')">
                        Batal
                    </x-border-button>
                    <x-primary-button type="submit">
                        {{ $authorId ? 'Simpan Perubahan' : 'Simpan' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="showDeleteModal" align="center" maxWidth="md">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h3>
            <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus penulis ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <x-border-button type="button" x-on:click="$dispatch('close')" class="!w-auto">
                    Batal
                </x-border-button>
                <x-danger-button type="button" wire:click="delete">
                    Hapus
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
