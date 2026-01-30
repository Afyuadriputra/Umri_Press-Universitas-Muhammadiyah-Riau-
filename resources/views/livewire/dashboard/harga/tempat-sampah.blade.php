<div class="p-6">
    @include('components.alert')

    <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 mb-4">Tempat Sampah</h2>
    <div class="flex flex-wrap justify-between items-center mb-6">
        <a href="{{ route('semuaPaket') }}" wire:navigate>
            <x-border-button class="!inline-flex items-center gap-2 !w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Kembali
            </x-border-button>
        </a>
        <div class="flex gap-3">
            @if ($trashedPackages->isNotEmpty())
                <x-border-button wire:click="confirmRestoreAll" wire:loading.attr="disabled"
                    class="!inline-flex items-center gap-2 !w-auto">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 24 24">
                        <path
                            d="M 11.03125 3 C 9.8865255 3 8.8219757 3.6090929 8.28125 4.6152344 L 8.2734375 4.6289062 L 7.8125 5.5527344 A 1.0001 1.0001 0 1 0 9.5996094 6.4472656 L 10.042969 5.5625 L 10.044922 5.5625 C 10.222484 5.2334243 10.598621 5 11.03125 5 L 13.019531 5 C 13.453413 5 13.83195 5.2321005 14.009766 5.5644531 L 14.019531 5.5820312 L 15.611328 8.2910156 L 14.251953 9.0664062 C 13.864953 9.2874063 13.937188 9.8644219 14.367188 9.9824219 L 18.017578 10.982422 C 18.283578 11.055422 18.557859 10.898813 18.630859 10.632812 L 19.630859 6.9824219 C 19.748859 6.5524219 19.287391 6.1960156 18.900391 6.4160156 L 17.349609 7.3007812 L 15.773438 4.6210938 C 15.233254 3.6114463 14.165649 3 13.019531 3 L 11.03125 3 z M 6.8203125 9.0058594 L 3.0859375 9.6054688 C 2.6459375 9.6764687 2.5110938 10.244859 2.8710938 10.505859 L 4.2246094 11.484375 L 2.3847656 14.59375 L 2.375 14.611328 C 1.8464894 15.596074 1.9302039 16.807596 2.5859375 17.714844 L 2.5859375 17.716797 L 3.3125 18.71875 C 3.8991007 19.53189 4.8493769 20 5.8535156 20 L 8 20 A 1.0001 1.0001 0 1 0 8 18 L 5.8535156 18 C 5.4736544 18 5.1289929 17.819689 4.9335938 17.548828 L 4.2070312 16.544922 C 3.9867648 16.24017 3.9651824 15.881848 4.1386719 15.558594 L 5.8496094 12.660156 L 7.2050781 13.640625 C 7.5660781 13.901625 8.0631875 13.59625 7.9921875 13.15625 L 7.3925781 9.421875 C 7.3495781 9.148875 7.0933125 8.9628594 6.8203125 9.0058594 z M 19.960938 12.988281 A 1.0001 1.0001 0 0 0 19.183594 14.576172 L 19.888672 15.574219 C 20.050275 15.882608 20.027854 16.251837 19.816406 16.546875 L 19.820312 16.544922 L 19.089844 17.554688 C 18.898844 17.819209 18.550743 18 18.169922 18 L 15 18 L 15 16.509766 C 15 16.056766 14.451859 15.829391 14.130859 16.150391 L 11.640625 18.640625 C 11.441625 18.839625 11.441625 19.160375 11.640625 19.359375 L 14.130859 21.849609 C 14.451859 22.170609 15 21.943234 15 21.490234 L 15 20 L 18.169922 20 C 19.169101 20 20.121946 19.540134 20.710938 18.724609 L 21.441406 17.714844 L 21.443359 17.712891 C 22.089804 16.810875 22.183361 15.605037 21.650391 14.615234 L 21.621094 14.5625 L 20.816406 13.423828 A 1.0001 1.0001 0 0 0 19.960938 12.988281 z">
                        </path>
                    </svg>
                    Pulihkan Semua
                </x-border-button>

                <x-primary-button wire:click="confirmForceDeleteAll" wire:loading.attr="disabled"
                    class="!inline-flex items-center gap-2 !w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Hapus Semua Permanen
                </x-primary-button>
            @endif
        </div>
    </div>

    <!-- Search and Filter Section -->
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
                    <option value="newest">Terbaru Dihapus</option>
                    <option value="oldest">Terlama Dihapus</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
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
                            Tanggal Dihapus
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($trashedPackages as $package)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100 leading-none">
                                    {{ $package->nama }}
                                    <p><span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $package->slug }}</span></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-500 dark:text-neutral-400 max-w-xs line-clamp-2">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($package->deskripsi), 50) !!}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $package->deleted_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button wire:click="confirmRestore({{ $package->id }})"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Pulihkan
                                    </button>
                                    <button wire:click="confirmForceDelete({{ $package->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Hapus Permanen
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                Tidak ada paket yang dihapus
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $trashedPackages->links() }}
        </div>
    </div>

    <!-- Restore Confirmation Modal -->
    <x-modal name="confirmRestore" :show="false" align="center" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Pemulihan
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin memulihkan paket ini?
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="restore" wire:loading.attr="disabled">
                    Pulihkan
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Force Delete Confirmation Modal -->
    <x-modal name="confirmForceDelete" :show="false" align="center" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus Permanen
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus paket ini secara permanen? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="forceDelete" wire:loading.attr="disabled">
                    Hapus Permanen
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Restore All Confirmation Modal -->
    <x-modal name="confirmRestoreAll" :show="false" align="center" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Pemulihan Semua
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin memulihkan semua paket yang ada di tempat sampah?
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="restoreAll" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="restoreAll">Pulihkan Semua</span>
                    <span wire:loading wire:target="restoreAll">Memulihkan...</span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Force Delete All Confirmation Modal -->
    <x-modal name="confirmForceDeleteAll" :show="false" align="center" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus Semua Permanen
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus semua paket secara permanen? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">
                    Batal
                </x-border-button>
                <x-primary-button class="!w-auto" wire:click="forceDeleteAll" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="forceDeleteAll">Hapus Semua</span>
                    <span wire:loading wire:target="forceDeleteAll">Menghapus...</span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
