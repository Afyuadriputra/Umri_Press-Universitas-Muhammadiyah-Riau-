<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Pengaturan Surat</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Atur format nomor surat, unit, dan jenis surat.</p>
        </div>

        <form method="POST" action="{{ route('dashboard-surat.settings.update') }}" class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <x-input-label class="mb-1">Instansi</x-input-label>
                    <x-text-input name="instansi" value="{{ $settings['instansi'] }}" class="w-full" />
                </div>
                <div>
                    <x-input-label class="mb-1">Panjang Nomor</x-input-label>
                    <x-text-input type="number" name="sequence_length" value="{{ $settings['sequence_length'] }}" class="w-full" />
                </div>
                <div>
                    <x-input-label class="mb-1">Format Nomor</x-input-label>
                    <x-text-input name="number_format" value="{{ $settings['number_format'] }}" class="w-full" />
                </div>
            </div>
            <p class="text-xs text-neutral-500">Variabel: {sequence}, {instansi}, {jenis}, {unit}, {bulan_roman}, {bulan}, {tahun}</p>
            <div class="flex justify-end">
                <x-primary-button type="submit" class="!w-auto">Simpan</x-primary-button>
            </div>
        </form>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 space-y-4">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Unit/Divisi</h2>
                <form method="POST" action="{{ route('dashboard-surat.settings.unit.store') }}" class="flex flex-wrap gap-2">
                    @csrf
                    <x-text-input name="code" class="w-28" placeholder="Kode" required />
                    <x-text-input name="name" class="flex-1" placeholder="Nama Unit" required />
                    <x-primary-button type="submit" class="!w-auto">Tambah</x-primary-button>
                </form>
                <div class="space-y-2 text-sm">
                    @foreach ($units as $unit)
                        <div class="flex items-center justify-between rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-700">
                            <div>
                                <span class="font-semibold">{{ $unit->name }}</span>
                                <span class="text-xs text-neutral-500">({{ $unit->code }})</span>
                            </div>
                            <form method="POST" action="{{ route('dashboard-surat.settings.unit.destroy', $unit) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 space-y-4">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Jenis Surat</h2>
                <form method="POST" action="{{ route('dashboard-surat.settings.type.store') }}" class="flex flex-wrap gap-2">
                    @csrf
                    <x-text-input name="code" class="w-28" placeholder="Kode" required />
                    <x-text-input name="name" class="flex-1" placeholder="Nama Jenis" required />
                    <x-primary-button type="submit" class="!w-auto">Tambah</x-primary-button>
                </form>
                <div class="space-y-2 text-sm">
                    @foreach ($types as $type)
                        <div class="flex items-center justify-between rounded-lg border border-neutral-200 px-3 py-2 dark:border-neutral-700">
                            <div>
                                <span class="font-semibold">{{ $type->name }}</span>
                                <span class="text-xs text-neutral-500">({{ $type->code }})</span>
                            </div>
                            <form method="POST" action="{{ route('dashboard-surat.settings.type.destroy', $type) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-surat-layout>
