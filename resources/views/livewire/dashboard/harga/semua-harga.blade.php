<div class="p-6">
    @include('components.alert')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Daftar Paket Penerbitan</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('tempatSampahPaket') }}" wire:navigate>
                <x-border-button class="!inline-flex items-center gap-2 !w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Tempat Sampah {{ $trashCount > 0 ? '(' . $trashCount . ')' : '' }}
                </x-border-button>
            </a>

            <a href="{{ route('tambahPaket') }}" wire:navigate>
                <x-primary-button class="!inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Paket
                </x-primary-button>
            </a>
        </div>
    </div>

    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Paket
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan nama paket..." />
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Urutkan
                </label>
                <select wire:model.live="sortBy"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="position">Urutan Tampil</option>
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th scope="col" class="w-10"></th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Nama Paket
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Deskripsi
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
                <tbody wire:sortable="updateOrder" id="sortable-packages"
                    class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($packages as $package)
                        <tr wire:sortable.item="{{ $package->id }}" wire:key="package-{{ $package->id }}"
                            class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td wire:sortable.handle class="px-6 py-4 cursor-move">
                                <svg class="size-5 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100 leading-none">
                                        {{ $package->nama }}
                                        <p><span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $package->slug }}</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-500 dark:text-neutral-400 max-w-xs line-clamp-2">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($package->deskripsi), 50) !!}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleActive({{ $package->id }})"
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $package->active
                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400'
                                        : 'bg-neutral-100 text-neutral-800 dark:bg-neutral-800/20 dark:text-neutral-400' }}">
                                    {{ $package->active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="{{ route('editPaket', $package->slug) }}" wire:navigate
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </a>
                                <button wire:click="confirmDelete({{ $package->id }})"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                Tidak ada paket yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $packages->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirmDelete" :show="false" maxWidth="md" align="center">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus paket ini? Paket yang dihapus dapat dipulihkan dari tempat sampah.
            </p>
            <div class="mt-6 flex justify-end gap-3">
                <x-border-button x-on:click="$dispatch('close')" class="!w-auto">
                    Batal
                </x-border-button>
                <x-primary-button wire:click="delete" class="!w-auto">
                    Hapus
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
