<div class="p-6">
    @include('components.alert')

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Manajemen Role</h2>
        <x-primary-button wire:click="openCreateModal" class="!inline-flex items-center gap-2 !w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tambah Role
        </x-primary-button>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Key</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Dashboard</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">{{ $role->name }}</div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $role->description ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-300">{{ $role->key }}</td>
                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-300">
                                {{ count($role->surat_permissions ?? []) }} izin
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-300">
                                {{ count($role->dashboard_permissions ?? []) }} izin
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-300">
                                {{ count($role->author_permissions ?? []) }} izin
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-3">
                                    <button wire:click="edit({{ $role->id }})" class="text-blue-600 hover:text-blue-800">Edit</button>
                                    @if (! $role->is_system && ! $role->is_admin)
                                        <button wire:click="confirmDelete({{ $role->id }})" class="text-cgreen-600 hover:text-cgreen-800">Hapus</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">Belum ada role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-modal name="roleModal" :show="false" maxWidth="2xl">
        <div class="p-6 space-y-4">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $roleId ? 'Edit Role' : 'Tambah Role' }}</h2>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label>Key</x-input-label>
                    <input type="text" wire:model="role_key"
                        class="w-full mt-1 rounded-lg border-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-neutral-200"
                        placeholder="contoh: editor" @disabled($is_system) />
                    @error('role_key')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                </div>
                <div>
                    <x-input-label>Nama Role</x-input-label>
                    <x-text-input wire:model="name" class="w-full mt-1" placeholder="Editor" />
                    @error('name')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                </div>
            </div>
            <div>
                <x-input-label>Deskripsi</x-input-label>
                <x-text-input wire:model="description" class="w-full mt-1" placeholder="Keterangan singkat" />
                @error('description')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="flex items-center gap-3">
                <input id="roleSurat" type="checkbox" wire:model="can_access_surat" class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:ring-cgreen-200" />
                <label for="roleSurat" class="text-sm text-neutral-700 dark:text-neutral-300">Akses App Surat</label>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">
                <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                    <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">Permission App Surat</p>
                    <div class="mt-3 grid gap-2">
                        @foreach ($availableSuratPermissions as $key => $label)
                            <label class="flex items-center gap-2 text-xs text-neutral-700 dark:text-neutral-300">
                                <input type="checkbox" value="{{ $key }}" wire:model="surat_permissions" class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:ring-cgreen-200" @disabled($is_admin)>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                    <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">Permission Dashboard</p>
                    <div class="mt-3 grid gap-2">
                        @foreach ($availableDashboardPermissions as $key => $label)
                            <label class="flex items-center gap-2 text-xs text-neutral-700 dark:text-neutral-300">
                                <input type="checkbox" value="{{ $key }}" wire:model="dashboard_permissions" class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:ring-cgreen-200" @disabled($is_admin)>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                    <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">Permission Author</p>
                    <div class="mt-3 grid gap-2">
                        @foreach ($availableAuthorPermissions as $key => $label)
                            <label class="flex items-center gap-2 text-xs text-neutral-700 dark:text-neutral-300">
                                <input type="checkbox" value="{{ $key }}" wire:model="author_permissions" class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:ring-cgreen-200" @disabled($is_admin)>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-border-button type="button" x-on:click="$dispatch('close')" class="!w-auto">Batal</x-border-button>
                <x-primary-button type="button" wire:click="save" class="!w-auto">Simpan</x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="confirmDelete" :show="false" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">Hapus Role</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">Yakin menghapus role ini?</p>
            <div class="mt-6 flex justify-end gap-3">
                <x-border-button class="!w-auto" x-on:click="$dispatch('close')">Batal</x-border-button>
                <x-primary-button class="!w-auto" wire:click="delete">Hapus</x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
