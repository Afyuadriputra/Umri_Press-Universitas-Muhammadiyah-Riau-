<x-author-layout>
    <div class="p-6 space-y-6">
        @include('components.alert')

        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Pengaturan Rekening</h2>
            <p class="text-neutral-600 dark:text-neutral-400">Perbarui informasi rekening untuk pencairan royalti.</p>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 max-w-2xl">
            <form action="{{ route('author.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <x-input-label>Nama Bank</x-input-label>
                    <x-text-input type="text" name="bank_name" class="w-full mt-1" value="{{ old('bank_name', $author->bank_name) }}" />
                    @error('bank_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label>Nama Pemilik Rekening</x-input-label>
                    <x-text-input type="text" name="bank_account_name" class="w-full mt-1"
                        value="{{ old('bank_account_name', $author->bank_account_name) }}" />
                    @error('bank_account_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label>Nomor Rekening</x-input-label>
                    <x-text-input type="text" name="bank_account_number" class="w-full mt-1"
                        value="{{ old('bank_account_number', $author->bank_account_number) }}" />
                    @error('bank_account_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <x-primary-button type="submit">Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-author-layout>
