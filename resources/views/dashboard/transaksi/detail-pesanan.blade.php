<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="px-4 py-8 sm:px-8">
        <div class="max-w-5xl mx-auto space-y-6">
            <a href="{{ route('pesananLangsung') }}" class="inline-flex items-center text-sm text-cgreen-600 hover:text-cgreen-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Pesanan
            </a>

            @include('components.alert')

            <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-neutral-900 space-y-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-50">{{ $order->buku->judul }}</h1>
                        <p class="text-sm text-neutral-500">
                            ID Pesanan #{{ $order->id }} • {{ $order->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <span class="inline-flex rounded-full px-4 py-1 text-xs font-semibold
                        @class([
                            'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                            'bg-blue-100 text-blue-700' => in_array($order->status, ['verified', 'processing']),
                            'bg-green-100 text-green-700' => in_array($order->status, ['shipped', 'completed']),
                            'bg-red-100 text-red-700' => $order->status === 'cancelled',
                        ])">
                        {{ $statuses[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>

                <div class="grid gap-6 md:grid-cols-2 text-sm">
                    <article class="space-y-3">
                        <h2 class="font-semibold text-neutral-700 dark:text-neutral-300">Data Penerima</h2>
                        <p class="text-neutral-900 dark:text-neutral-50">{{ $order->recipient_name }}</p>
                        <p class="text-neutral-600">{{ $order->recipient_email }}</p>
                        <p class="text-neutral-600">{{ $order->recipient_phone }}</p>
                        <p class="text-neutral-600 capitalize">{{ $order->address_label ?? '-' }}</p>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <a href="tel:{{ $order->recipient_phone }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-cgreen-500 px-3 py-1.5 text-xs font-semibold text-cgreen-600 hover:bg-cgreen-50">
                                Hubungi via Telepon
                            </a>
                            <a href="mailto:{{ $order->recipient_email }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-cgreen-500 px-3 py-1.5 text-xs font-semibold text-cgreen-600 hover:bg-cgreen-50">
                                Kirim Email
                            </a>
                        </div>
                    </article>

                    <article>
                        <h2 class="font-semibold text-neutral-700 dark:text-neutral-300">Alamat</h2>
                        <p class="mt-2 text-neutral-600">{{ $order->alamat_lengkap }}</p>
                        <p class="text-neutral-600">
                            {{ $order->kelurahan }}, {{ $order->kecamatan }}, {{ $order->kota }},
                            {{ $order->provinsi }} {{ $order->kode_pos }}
                        </p>
                    </article>
                </div>

                <article class="space-y-2 text-sm">
                    <h2 class="font-semibold text-neutral-700 dark:text-neutral-300">Pembayaran</h2>
                    <p class="text-neutral-900 dark:text-neutral-50">{{ $order->paymentMethod->name }}</p>
                    @if ($order->paymentMethod->account_number)
                        <p class="text-neutral-600">
                            {{ $order->paymentMethod->account_number }} — {{ $order->paymentMethod->account_name }}
                        </p>
                    @endif
                    <div class="space-y-1">
                        @if ($order->harga_asli !== $order->harga_setelah_diskon)
                            <p class="text-sm text-red-500 line-through decoration-2">
                                Rp {{ number_format($order->harga_asli, 0, ',', '.') }}
                            </p>
                        @endif
                        <p class="text-3xl font-bold text-cgreen-600">
                            Rp {{ number_format($order->harga_setelah_diskon, 0, ',', '.') }}
                        </p>
                    </div>
                    @if ($order->bukti_pembayaran)
                        <a href="{{ Storage::url($order->bukti_pembayaran) }}" target="_blank"
                            class="inline-flex items-center text-cgreen-600 hover:underline">
                            Lihat Bukti Pembayaran
                        </a>
                    @endif
                </article>

                @if ($order->catatan_pengguna)
                    <article class="text-sm">
                        <h2 class="font-semibold text-neutral-700 dark:text-neutral-300">Catatan Pengguna</h2>
                        <p class="mt-2 text-neutral-600">{{ $order->catatan_pengguna }}</p>
                    </article>
                @endif
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-50 mb-4">Proses Pesanan</h2>
                <form action="{{ route('pesananLangsung.update', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Pesanan</label>
                        <select name="status"
                            class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="3"
                            class="mt-1 w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500">{{ old('catatan_admin', $order->catatan_admin) }}</textarea>
                        @error('catatan_admin')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('pesananLangsung') }}"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-cgreen-600 px-6 py-2 text-white font-semibold hover:bg-cgreen-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>