<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Detail Surat Keluar</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $letter->subject }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard-surat.outgoing.edit', $letter) }}"
                    class="inline-flex items-center rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Edit
                </a>
                @unless ($letter->status === 'archived')
                    <form method="POST" action="{{ route('dashboard-surat.outgoing.archive.store', $letter) }}" onsubmit="return confirm('Arsipkan surat ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-neutral-100 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700">
                            Arsipkan
                        </button>
                    </form>
                @endunless
                <a href="{{ route('dashboard-surat.outgoing.index') }}"
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
                        <dt class="text-neutral-500">Tanggal Kirim</dt>
                        <dd>{{ optional($letter->sent_at)->format('d M Y') ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Nomor Surat</dt>
                        <dd>{{ $letter->letter_number ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Penerima</dt>
                        <dd>{{ $letter->recipient }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">No. WhatsApp</dt>
                        <dd>{{ $letter->recipient_phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Jabatan</dt>
                        <dd>{{ $letter->recipient_position ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Jenis Surat</dt>
                        <dd>{{ $letter->letter_type ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Unit</dt>
                        <dd>{{ $letter->unit_code ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Status</dt>
                        <dd>
                            <x-surat-status-badge :status="$letter->status" context="outgoing" />
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500">Approver</dt>
                        <dd>{{ $letter->approver?->name ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-4 text-sm text-neutral-600 dark:text-neutral-400">
                    <p class="font-semibold text-neutral-900 dark:text-neutral-100">Isi Surat</p>
                    <p class="mt-2 whitespace-pre-line">{{ $letter->body ?? '-' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">File</h2>
                    <div class="mt-3 space-y-2 text-sm">
                        <div>
                            <span class="text-neutral-500">Lampiran:</span>
                            @if ($letter->attachment_path)
                                <a href="{{ asset($letter->attachment_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-neutral-500">File Final:</span>
                            @if ($letter->final_file_path)
                                <a href="{{ asset($letter->final_file_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-neutral-500">Tanda Tangan:</span>
                            @if ($letter->signature_path)
                                <a href="{{ asset($letter->signature_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                    @if ($letter->recipient_phone)
                        @php
                            $digits = preg_replace('/\\D+/', '', $letter->recipient_phone);
                            $waLink = 'https://wa.me/' . ltrim($digits, '0');
                        @endphp
                        <a href="{{ $waLink }}" target="_blank" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            Kirim via WhatsApp
                        </a>
                    @endif
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Verifikasi</h2>
                    @if ($letter->verification_code)
                        @php
                            $verifyUrl = route('surat.verify', $letter->verification_code);
                            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' . urlencode($verifyUrl);
                        @endphp
                        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                            <img src="{{ $qrUrl }}" alt="QR Verifikasi" class="h-40 w-40 border border-neutral-200">
                            <div>
                                <p>Link verifikasi:</p>
                                <a href="{{ $verifyUrl }}" target="_blank" class="text-cgreen-600 underline">Buka halaman verifikasi</a>
                                <p class="mt-2 text-xs text-neutral-500">Kode: {{ $letter->verification_code }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-neutral-500">Kode verifikasi belum tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-surat-layout>
