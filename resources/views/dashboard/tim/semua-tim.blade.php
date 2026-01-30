<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    @php
        $structureSetting = \App\Models\Pengaturan::where('key', 'naskah_structure_image')->first();
        $adminWaSetting = \App\Models\Pengaturan::where('key', 'admin_wa_number')->first();
    @endphp

    <div class="mb-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-green-700 dark:bg-green-900/30 dark:text-green-100">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Gambar Struktur Kirim Naskah</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Upload/update gambar struktur (disarankan 1280x719, 24-bit, 96 dpi).</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <div>
                @if ($structureSetting && $structureSetting->value)
                    <div class="overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <img src="{{ asset($structureSetting->value) }}" alt="Struktur Kirim Naskah" class="w-full h-auto object-contain">
                    </div>
                @else
                    <div class="flex h-48 items-center justify-center rounded-lg border-2 border-dashed border-neutral-300 text-neutral-500 dark:border-neutral-700 dark:text-neutral-400">
                        Belum ada gambar struktur
                    </div>
                @endif
            </div>
            <div>
                <form action="{{ route('tim.updateStructure') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-200">Pilih Gambar</label>
                    <input type="file" name="structure_image" accept="image/*"
                        class="block w-full text-sm text-neutral-600 dark:text-neutral-300
                        file:mr-4 file:rounded-md file:border-0 file:bg-cgreen-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-cgreen-700
                        hover:file:bg-cgreen-100 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('structure_image')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <x-primary-button type="submit">Simpan Gambar</x-primary-button>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
        <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Nomor WhatsApp Admin</h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Atur nomor WA tujuan untuk pesanan langsung dan kirim naskah.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <div>
                <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-4 text-neutral-800 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                    <p class="text-sm font-semibold">Nomor Saat Ini</p>
                    <p class="text-2xl font-bold tracking-wide mt-1">{{ $adminWaSetting->value ?? 'Belum diatur' }}</p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">Gunakan format internasional tanpa +, contoh: 6281234567890.</p>
                </div>
            </div>
            <div>
                <form action="{{ route('tim.updateAdminWa') }}" method="POST" class="space-y-3">
                    @csrf
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-200">Nomor WhatsApp Admin</label>
                    <input type="text" name="admin_wa_number" value="{{ old('admin_wa_number', $adminWaSetting->value ?? '6287837151510') }}"
                        class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-neutral-800 shadow-sm focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100" placeholder="Contoh: 6281234567890">
                    @error('admin_wa_number')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <x-primary-button type="submit">Simpan Nomor</x-primary-button>
                </form>
            </div>
        </div>
    </div>

	<livewire:dashboard.tim.semua-tim />
</x-app-layout>
