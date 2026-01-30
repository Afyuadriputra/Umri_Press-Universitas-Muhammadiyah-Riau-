<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Detail Surat Masuk</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $letter->subject }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard-surat.incoming.edit', $letter) }}"
                    class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Edit
                </a>
                @unless ($letter->status === 'arsip')
                    <form method="POST" action="{{ route('dashboard-surat.incoming.archive.store', $letter) }}" onsubmit="return confirm('Arsipkan surat ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-neutral-100 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700">
                            Arsipkan
                        </button>
                    </form>
                @endunless
                <a href="{{ route('dashboard-surat.incoming.index') }}"
                    class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Informasi Surat</h2>
                <dl class="mt-4 space-y-3 text-sm text-neutral-700 dark:text-neutral-200">
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Tanggal Terima</dt>
                        <dd>{{ optional($letter->received_at)->format('d M Y') }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Tanggal Surat</dt>
                        <dd>{{ optional($letter->letter_date)->format('d M Y') ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Nomor Surat</dt>
                        <dd>{{ $letter->letter_number ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Pengirim</dt>
                        <dd>{{ $letter->sender }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Status</dt>
                        <dd>
                            <x-surat-status-badge :status="$letter->status" context="incoming" />
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">PIC</dt>
                        <dd>{{ $letter->assignedUser?->name ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-4 text-sm text-neutral-600 dark:text-neutral-400">
                    <p class="font-semibold text-neutral-900 dark:text-neutral-100">Ringkasan</p>
                    <p class="mt-2">{{ $letter->summary ?? '-' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Disposisi & Catatan</h2>
                    <p class="mt-3 text-sm text-neutral-700 dark:text-neutral-200">
                        <span class="text-neutral-500">Catatan Disposisi:</span>
                        {{ $letter->disposition_note ?? '-' }}
                    </p>
                    <p class="mt-2 text-sm text-neutral-700 dark:text-neutral-200">
                        <span class="text-neutral-500">Catatan Internal:</span>
                        {{ $letter->internal_notes ?? '-' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">File</h2>
                    <div class="mt-3 space-y-2 text-sm">
                        <div>
                            <span class="text-neutral-500">Scan:</span>
                            @if ($letter->scan_path)
                                <a href="{{ asset($letter->scan_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-neutral-500">Lampiran:</span>
                            @if ($letter->attachment_path)
                                <a href="{{ asset($letter->attachment_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Disposisi Multi-level</h2>

            @php
                $primaryRecipient = $letter->dispositions
                    ->flatMap(fn ($disposition) => $disposition->recipients)
                    ->firstWhere('role', 'to');
                $primaryUser = $primaryRecipient?->user ?? $letter->assignedUser;
                $primaryUserId = $primaryUser?->id;
            @endphp

            <form method="POST" action="{{ route('dashboard-surat.disposisi.store', $letter) }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <x-input-label class="mb-1">PIC Utama</x-input-label>
                    @if ($primaryUserId)
                        <input type="hidden" name="to_user_id" value="{{ $primaryUserId }}" />
                        <div class="rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                            {{ $primaryUser->name }}
                        </div>
                        <p class="mt-1 text-xs text-neutral-500">PIC utama sudah ditetapkan, cukup isi CC.</p>
                    @else
                        <x-select name="to_user_id" class="w-full" required>
                            <option value="">Pilih PIC</option>
                            @foreach ($staff as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select>
                    @endif
                </div>
                <div>
                    <x-input-label class="mb-1">CC (boleh lebih dari satu)</x-input-label>
                    <x-select name="cc_user_ids[]" class="w-full" multiple>
                        @foreach ($staff as $user)
                            @if ($primaryUserId && $user->id === $primaryUserId)
                                @continue
                            @endif
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div>
                    <x-input-label class="mb-1">Due Date</x-input-label>
                    <x-text-input type="date" name="due_date" class="w-full" />
                </div>
                <div>
                    <x-input-label class="mb-1">Instruksi Disposisi</x-input-label>
                    <x-text-input type="text" name="instruction" class="w-full" placeholder="Telaah / balas / arsip / koordinasi" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label class="mb-1">Catatan</x-input-label>
                    <textarea name="note" rows="3"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <x-primary-button type="submit" class="!w-auto">Kirim Disposisi</x-primary-button>
                </div>
            </form>

            <div class="mt-6 space-y-3">
                @forelse ($letter->dispositions as $disposition)
                    <div class="rounded-xl border border-neutral-200 p-4 text-sm text-neutral-700 dark:border-neutral-700 dark:text-neutral-200">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <p class="font-semibold">Instruksi: {{ $disposition->instruction ?? '-' }}</p>
                                <p class="text-neutral-500">Due: {{ optional($disposition->due_date)->format('d M Y') ?? '-' }}</p>
                            </div>
                            <x-surat-status-badge :status="$disposition->status" context="disposisi" />
                        </div>
                        <p class="mt-2 text-neutral-500">Catatan: {{ $disposition->note ?? '-' }}</p>
                        <div class="mt-2 text-xs text-neutral-500">
                            PIC:
                            {{ $disposition->recipients->firstWhere('role', 'to')?->user?->name ?? '-' }}
                            | CC:
                            {{ $disposition->recipients->where('role', 'cc')->pluck('user.name')->join(', ') ?: '-' }}
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500">Belum ada disposisi.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-surat-layout>
