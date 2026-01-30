<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Edit Surat Keluar</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Perbarui data surat keluar.</p>
        </div>

        <form method="POST" action="{{ route('dashboard-surat.outgoing.update', $letter) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Nomor Surat</x-input-label>
                    <x-text-input type="text" name="letter_number" value="{{ old('letter_number', $letter->letter_number) }}" class="w-full" />
                    @error('letter_number') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Tanggal Kirim</x-input-label>
                    <x-text-input type="date" name="sent_at" value="{{ old('sent_at', optional($letter->sent_at)->format('Y-m-d')) }}" class="w-full" />
                    @error('sent_at') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Unit/Divisi</x-input-label>
                    <x-select name="unit_code" class="w-full" required>
                        <option value="">Pilih Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->code }}" @selected(old('unit_code', $letter->unit_code) === $unit->code)>{{ $unit->name }} ({{ $unit->code }})</option>
                        @endforeach
                    </x-select>
                    @error('unit_code') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Jenis Surat</x-input-label>
                    <x-select name="letter_type" class="w-full" required>
                        <option value="">Pilih Jenis</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->code }}" @selected(old('letter_type', $letter->letter_type) === $type->code)>{{ $type->name }} ({{ $type->code }})</option>
                        @endforeach
                    </x-select>
                    @error('letter_type') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Penerima</x-input-label>
                    <x-text-input type="text" name="recipient" value="{{ old('recipient', $letter->recipient) }}" class="w-full" required />
                    @error('recipient') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">No. WhatsApp Penerima</x-input-label>
                    <x-text-input type="text" name="recipient_phone" value="{{ old('recipient_phone', $letter->recipient_phone) }}" class="w-full" placeholder="628xxxx" />
                    @error('recipient_phone') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Jabatan Penerima</x-input-label>
                    <x-text-input type="text" name="recipient_position" value="{{ old('recipient_position', $letter->recipient_position) }}" class="w-full" />
                    @error('recipient_position') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Template Surat</x-input-label>
                    <x-select name="template_id" class="w-full">
                        <option value="">Tanpa Template</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}" @selected(old('template_id', $letter->template_id) == $template->id)>{{ $template->name }}</option>
                        @endforeach
                    </x-select>
                    @error('template_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Perihal</x-input-label>
                    <x-text-input type="text" name="subject" value="{{ old('subject', $letter->subject) }}" class="w-full" required />
                    @error('subject') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Isi Surat</x-input-label>
                    <textarea name="body" rows="5"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">{{ old('body', $letter->body) }}</textarea>
                    <p class="mt-1 text-xs text-neutral-500">Template hanya mengisi otomatis saat membuat surat jika isi kosong.</p>
                    @error('body') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Status</x-input-label>
                    <x-select name="status" class="w-full">
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected(old('status', $letter->status) === $status)>{{ strtoupper($status) }}</option>
                        @endforeach
                    </x-select>
                    @error('status') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Approver</x-input-label>
                    <x-select name="approved_by" class="w-full">
                        <option value="">Belum ditentukan</option>
                        @foreach ($approvers as $user)
                            <option value="{{ $user->id }}" @selected(old('approved_by', $letter->approved_by) == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                    @error('approved_by') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="mb-1">Lampiran Pendukung</x-input-label>
                    <input type="file" name="attachment_file" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('attachment_file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">File Final (PDF/JPG)</x-input-label>
                    <input type="file" name="final_file" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('final_file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-input-label class="mb-1">Tanda Tangan (PNG/JPG)</x-input-label>
                    <input type="file" name="signature_file" accept=".png,.jpg,.jpeg"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('signature_file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2 text-xs text-neutral-500 dark:text-neutral-400">
                    @if ($letter->attachment_path)
                        <div>
                            Lampiran saat ini: <a href="{{ asset($letter->attachment_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                        </div>
                    @endif
                    @if ($letter->final_file_path)
                        <div>
                            File final saat ini: <a href="{{ asset($letter->final_file_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                        </div>
                    @endif
                    @if ($letter->signature_path)
                        <div>
                            Tanda tangan saat ini: <a href="{{ asset($letter->signature_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard-surat.outgoing.show', $letter) }}" class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Batal
                </a>
                <x-primary-button type="submit" class="!w-auto">Simpan Perubahan</x-primary-button>
            </div>
        </form>
    </div>
</x-surat-layout>
