<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="py-16">
        <x-container>
            <div class="mx-auto max-w-2xl rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-wide text-cgreen-600">Verifikasi Surat</p>
                    <h1 class="mt-2 text-2xl font-bold text-neutral-900">Hasil Verifikasi</h1>
                </div>

                @if ($letter)
                    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                        Surat valid dan terdaftar di sistem UMRI Press.
                    </div>

                    <div class="mt-6 space-y-3 text-sm text-neutral-700">
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Status Verifikasi</span>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">VALID</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Nomor Surat</span>
                            <span class="font-semibold">{{ $letter->letter_number ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Tanggal</span>
                            <span>{{ optional($letter->sent_at)->format('d M Y') ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Penerima</span>
                            <span>{{ $letter->recipient }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Perihal</span>
                            <span>{{ $letter->subject }}</span>
                        </div>
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Jenis / Unit</span>
                            <span>{{ $letter->letter_type ?? '-' }} / {{ $letter->unit_code ?? '-' }}</span>
                        </div>
                        @if ($letter->final_file_path)
                            <div class="flex justify-between gap-3">
                                <span class="text-neutral-500">File Final</span>
                                <a href="{{ asset($letter->final_file_path) }}" target="_blank" class="text-cgreen-600 underline">Lihat PDF</a>
                            </div>
                        @endif
                        <div class="flex justify-between gap-3">
                            <span class="text-neutral-500">Kode Verifikasi</span>
                            <span class="font-mono">{{ $code }}</span>
                        </div>
                    </div>
                @else
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        Kode verifikasi tidak ditemukan atau sudah tidak berlaku.
                    </div>
                    <div class="mt-3 text-sm">
                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">TIDAK VALID</span>
                    </div>
                    <p class="mt-4 text-sm text-neutral-600">Periksa kembali kode pada QR atau hubungi admin.</p>
                @endif
            </div>
        </x-container>
    </section>
</x-main-layout>
