<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Edit Template</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Perbarui template surat keluar.</p>
        </div>

        <form method="POST" action="{{ route('dashboard-surat.template.update', $template) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Nama Template</x-input-label>
                    <x-text-input name="name" value="{{ old('name', $template->name) }}" class="w-full" required />
                    @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Jenis Surat</x-input-label>
                    <x-select name="type_code" class="w-full">
                        <option value="">Umum</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->code }}" @selected(old('type_code', $template->type_code) === $type->code)>{{ $type->name }} ({{ $type->code }})</option>
                        @endforeach
                    </x-select>
                    @error('type_code') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Isi Template</x-input-label>
                    <textarea name="content" rows="8"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('content', $template->content) }}</textarea>
                    @error('content') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Variabel (pisahkan dengan koma)</x-input-label>
                    <x-text-input name="variables" value="{{ old('variables', $template->variables ? implode(',', $template->variables) : '') }}" class="w-full" placeholder="nomor,tanggal,penerima,jabatan,perihal,isi" />
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50" @checked(old('is_active', $template->is_active))>
                    <label class="text-sm text-neutral-700 dark:text-neutral-300">Aktif</label>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard-surat.template.index') }}" class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Batal
                </a>
                <x-primary-button type="submit" class="!w-auto">Simpan Perubahan</x-primary-button>
            </div>
        </form>
    </div>
</x-surat-layout>
