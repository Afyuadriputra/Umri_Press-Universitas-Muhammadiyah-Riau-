<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Input Surat Masuk</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Lengkapi data surat masuk.</p>
        </div>

        <form method="POST" action="{{ route('dashboard-surat.incoming.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Tanggal Terima</x-input-label>
                    <x-text-input type="date" name="received_at" value="{{ old('received_at') }}" class="w-full" required />
                    @error('received_at') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Tanggal Surat</x-input-label>
                    <x-text-input type="date" name="letter_date" value="{{ old('letter_date') }}" class="w-full" />
                    @error('letter_date') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Nomor Surat</x-input-label>
                    <x-text-input type="text" name="letter_number" value="{{ old('letter_number') }}" class="w-full" />
                    @error('letter_number') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Pengirim</x-input-label>
                    <x-text-input type="text" name="sender" value="{{ old('sender') }}" class="w-full" required />
                    @error('sender') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Perihal</x-input-label>
                    <x-text-input type="text" name="subject" value="{{ old('subject') }}" class="w-full" required />
                    @error('subject') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Ringkasan</x-input-label>
                    <textarea name="summary" rows="3"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('summary') }}</textarea>
                    @error('summary') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Status</x-input-label>
                    <x-select name="status" class="w-full">
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected(old('status', 'baru') === $status)>{{ strtoupper($status) }}</option>
                        @endforeach
                    </x-select>
                    @error('status') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">PIC</x-input-label>
                    <x-select name="assigned_user_id" class="w-full">
                        <option value="">Belum ditugaskan</option>
                        @foreach ($staff as $user)
                            <option value="{{ $user->id }}" @selected(old('assigned_user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                    @error('assigned_user_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Catatan Disposisi</x-input-label>
                    <textarea name="disposition_note" rows="3"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('disposition_note') }}</textarea>
                    @error('disposition_note') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Catatan Internal</x-input-label>
                    <textarea name="internal_notes" rows="3"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('internal_notes') }}</textarea>
                    @error('internal_notes') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Upload Scan (PDF/JPG)</x-input-label>
                    <input type="file" name="scan_file" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('scan_file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Lampiran</x-input-label>
                    <input type="file" name="attachment_file" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('attachment_file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard-surat.incoming.index') }}" class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Batal
                </a>
                <x-primary-button type="submit" class="!w-auto">Simpan</x-primary-button>
            </div>
        </form>
    </div>
</x-surat-layout>
