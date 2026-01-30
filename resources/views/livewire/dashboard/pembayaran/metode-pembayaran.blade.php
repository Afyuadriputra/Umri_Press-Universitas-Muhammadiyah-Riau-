<div class="p-6 space-y-6">
    @include('components.alert')

    <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-50">Metode Pembayaran</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Kelola opsi pembayaran untuk pembelian langsung via UMRI Press.</p>

        <form wire:submit.prevent="save" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Metode</label>
                <input type="text" wire:model.defer="name"
                    class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500"
                    placeholder="Contoh: Bank BCA" />
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Jenis</label>
                <select wire:model.defer="type"
                    class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500">
                    <option value="bank">Bank</option>
                    <option value="ewallet">Dompet Digital</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                @error('type')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nama Pemilik / Merchant</label>
                <input type="text" wire:model.defer="account_name"
                    class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                @error('account_name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Nomor Rekening / Akun</label>
                <input type="text" wire:model.defer="account_number"
                    class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                @error('account_number')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Instruksi Tambahan</label>
                <textarea rows="3" wire:model.defer="instructions"
                    class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500"
                    placeholder="Contoh: Sertakan bukti transfer"></textarea>
                @error('instructions')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Logo Metode (opsional)</label>
                <input type="file" wire:model="logo" accept=".png,.jpg,.jpeg,.svg"
                    class="mt-1 block w-full text-sm text-neutral-500 file:mr-4 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-4 file:py-2 file:font-semibold file:text-cgreen-600 hover:file:bg-cgreen-100" />
                @error('logo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <div wire:loading wire:target="logo" class="text-xs text-neutral-500 mt-1">Mengunggah logo...</div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" wire:model.defer="is_active"
                    class="rounded border-neutral-300 text-cgreen-600 focus:ring-cgreen-500">
                <label for="is_active" class="text-sm text-neutral-700 dark:text-neutral-300">Aktif</label>
            </div>

            <div class="md:col-span-2 flex items-center gap-3">
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-cgreen-600 text-white font-semibold hover:bg-cgreen-700">
                    {{ $methodId ? 'Perbarui Metode' : 'Tambah Metode' }}
                </button>
                @if ($methodId)
                    <button type="button" wire:click="resetForm" class="px-4 py-2 text-sm text-neutral-500">
                        Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-50">Daftar Metode</h3>
                <p class="text-sm text-neutral-500">Total: {{ $methods->total() }} metode</p>
            </div>
            <div class="w-full md:w-72">
                <input type="text" wire:model.debounce.400ms="search" placeholder="Cari metode..."
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Metode</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Rekening</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                    @forelse ($methods as $method)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-xl border border-neutral-200 bg-neutral-50 flex items-center justify-center dark:border-neutral-700 dark:bg-neutral-800">
                                        @if ($method->logo_path)
                                            <img src="{{ Storage::disk('public')->url($method->logo_path) }}" alt="{{ $method->name }}" class="h-full w-full object-contain p-2" />
                                        @else
                                            <span class="text-xs font-semibold text-neutral-500">Logo</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $method->name }}</p>
                                        <p class="text-xs text-neutral-500 capitalize">{{ $method->type }}</p>
                                    </div>
                                </div>
                                @if ($method->instructions)
                                    <p class="text-xs text-neutral-400 mt-1">{{ \Illuminate\Support\Str::limit($method->instructions, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-300">
                                @if ($method->account_number)
                                    <p class="font-semibold">{{ $method->account_number }}</p>
                                    <p class="text-xs text-neutral-500">{{ $method->account_name }}</p>
                                @else
                                    <span class="text-xs text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($method->is_active)
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-neutral-200 text-neutral-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="edit({{ $method->id }})"
                                    class="text-sm text-cgreen-600 hover:underline">Edit</button>
                                <button wire:click="delete({{ $method->id }})"
                                    onclick="return confirm('Hapus metode ini?')"
                                    class="text-sm text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-neutral-500">Belum ada metode pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $methods->links() }}
        </div>
    </div>
</div>
