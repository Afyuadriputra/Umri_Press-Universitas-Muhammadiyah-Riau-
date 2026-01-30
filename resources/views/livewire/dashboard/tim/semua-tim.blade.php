<div class="p-6">
    @include('components.alert')

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Daftar Tim</h2>
        <div class="flex flex-wrap gap-3">

            <a href="{{ route('tempatSampahTim') }}" wire:navigate>
                <x-border-button class="!inline-flex items-center gap-2 !w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
    
                    Tempat Sampah {{ $trashCount > 0 ? '(' . $trashCount . ')' : '' }}
                </x-border-button>
            </a>
            <a href="{{ route('tambahTim') }}" wire:navigate>
                <x-primary-button class="!inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Anggota Tim
                </x-primary-button>
            </a>
        </div>
    </div>

    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Cari Anggota Tim
                </label>
                <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full"
                    placeholder="Cari berdasarkan nama atau jabatan..." />
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
                            Foto
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Informasi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Social Media
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody wire:sortable="updateOrder" id="sortable-team"
                    class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach ($teamMembers as $member)
                        <tr wire:sortable.item="{{ $member->id }}" wire:key="team-{{ $member->id }}"
                            class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                            <td wire:sortable.handle class="px-6 py-4 cursor-move">
                                <svg class="size-5 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset($member->foto) }}" alt="{{ $member->nama }}"
                                    class="w-16 h-16 object-cover rounded-full">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $member->nama }}
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $member->jabatan }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @if ($member->instagram)
                                        <a href="{{ $member->instagram }}" target="_blank"
                                            class="text-neutral-400 hover:text-neutral-500">
                                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($member->facebook)
                                        <a href="{{ $member->facebook }}" target="_blank"
                                            class="text-neutral-400 hover:text-neutral-500">
                                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-3">
                                    <a href="{{ route('editTim', $member->slug) }}" wire:navigate
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                    <button wire:click="confirmDelete({{ $member->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $teamMembers->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirmDelete" :show="false" align="center">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">
                Konfirmasi Hapus
            </h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                Apakah Anda yakin ingin menghapus anggota tim ini?
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
