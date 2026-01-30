<div id="beli-langsung" class="space-y-6">
    {{-- Ringkasan --}}
    <section class="rounded-2xl border border-neutral-200/70 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
        <p class="text-sm font-semibold uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Ringkasan Pesanan</p>
        <div class="mt-2 flex flex-wrap items-start gap-3">
            <h3 class="text-xl font-bold text-neutral-900 dark:text-neutral-50">{{ $book->judul }}</h3>
            <div class="flex gap-2">
                @if ($book->is_hard_available)
                    <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">Hardfile</span>
                @endif
                @if ($book->is_soft_available)
                    <span class="rounded-full bg-cgreen-50 px-3 py-1 text-xs font-semibold text-cgreen-700 dark:bg-neutral-800 dark:text-cgreen-300">Softfile (PDF)</span>
                @endif
            </div>
        </div>
        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-700 dark:bg-neutral-800">
                <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Hardfile</p>
                <p class="text-lg font-bold text-cgreen-600">
                    Rp {{ number_format($book->harga, 0, ',', '.') }}
                </p>
                @if ($book->diskon_hard > 0)
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Diskon {{ $book->diskon_hard }}% → Rp {{ number_format($book->harga_setelah_diskon, 0, ',', '.') }}
                    </p>
                @elseif ($book->diskon > 0)
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Diskon {{ $book->diskon }}% → Rp {{ number_format($book->harga_setelah_diskon, 0, ',', '.') }}
                    </p>
                @endif
            </div>
            <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-700 dark:bg-neutral-800">
                <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Softfile (PDF)</p>
                <p class="text-lg font-bold text-cgreen-600">
                    @if($book->harga_soft !== null)
                        Rp {{ number_format($book->harga_soft, 0, ',', '.') }}
                    @else
                        <span class="text-neutral-500 text-sm">Belum diatur</span>
                    @endif
                </p>
                @if ($book->harga_soft !== null)
                    @if($book->diskon_soft > 0)
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Diskon {{ $book->diskon_soft }}% → Rp {{ number_format($book->harga_soft_setelah_diskon, 0, ',', '.') }}
                        </p>
                    @elseif($book->diskon > 0)
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Diskon {{ $book->diskon }}% → Rp {{ number_format($book->harga_soft_setelah_diskon, 0, ',', '.') }}
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </section>

    {{-- Alerts --}}
    @if ($successMessage)
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 dark:border-green-900 dark:bg-green-900/30 dark:text-green-100">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold">{{ $successMessage }}</p>
                    <p class="text-xs text-green-800/80 dark:text-green-200/80">Link bukti pembayaran akan otomatis tercantum di WhatsApp dan dikirim ke email admin.</p>
                </div>
                @if ($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                        Buka WhatsApp lagi
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
            </div>
            @if ($proofDownloadUrl)
                <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between text-sm text-green-900 dark:text-green-100/90">
                    <span>Bukti pembayaran Anda tersimpan. Anda bisa membuka atau mengunduh jika dibutuhkan.</span>
                    <a href="{{ $proofDownloadUrl }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg bg-white/80 px-3 py-1.5 text-sm font-semibold text-green-700 ring-1 ring-green-200 hover:bg-white">
                        Buka bukti pembayaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 4.5A1.5 1.5 0 014.5 3h11A1.5 1.5 0 0117 4.5v11a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 013 15.5v-11ZM8 7a2 2 0 114 0v2a2 2 0 11-4 0V7Zm-2.5 6a3.5 3.5 0 117 0h-7Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if ($paymentMethods->isEmpty())
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-700">
            Metode pembayaran belum tersedia. Silakan hubungi admin UMRI Press.
        </div>
    @else
        @if (empty($adminEmail))
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800 dark:border-amber-900 dark:bg-amber-900/20 dark:text-amber-100">
                Email admin pembayaran belum diatur. Bukti pembayaran akan tetap dikirim via WhatsApp.
            </div>
        @endif
        <form wire:submit.prevent="submit" class="space-y-6">
            {{-- Pilihan format --}}
            <div class="rounded-2xl border border-neutral-200/70 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900 space-y-3">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Pilih Format Buku</h4>
                <div class="flex flex-col gap-2">
                    <label class="flex items-start gap-3 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-neutral-800 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 {{ $book->is_hard_available ? '' : 'opacity-60' }}">
                        <input type="radio" wire:model="tipe_order" value="hard" {{ $book->is_hard_available ? '' : 'disabled' }}
                            class="mt-1 h-4 w-4 text-cgreen-600 focus:ring-cgreen-500 border-neutral-300 dark:border-neutral-600">
                        <div>
                            <p class="text-sm font-semibold">Hardfile (cetak)</p>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400">Buku fisik akan dikirim ke alamat Anda.</p>
                            <p class="text-xs text-neutral-700 dark:text-neutral-300">
                                Harga: Rp {{ number_format($book->harga_setelah_diskon, 0, ',', '.') }}
                                @if(($book->diskon_hard ?? $book->diskon) > 0)
                                    <span class="text-neutral-500">(Diskon {{ $book->diskon_hard ?? $book->diskon }}%)</span>
                                @endif
                            </p>
                            @unless($book->is_hard_available)
                                <p class="text-xs text-red-500">Tidak tersedia.</p>
                            @endunless
                        </div>
                    </label>

                    <label class="flex items-start gap-3 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-neutral-800 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 {{ $book->is_soft_available ? '' : 'opacity-60' }}">
                        <input type="radio" wire:model="tipe_order" value="soft" {{ $book->is_soft_available ? '' : 'disabled' }}
                            class="mt-1 h-4 w-4 text-cgreen-600 focus:ring-cgreen-500 border-neutral-300 dark:border-neutral-600">
                        <div>
                            <p class="text-sm font-semibold">Softfile (PDF)</p>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400">Dapat diunduh setelah pembayaran dikonfirmasi admin.</p>
                            @if($book->harga_soft !== null)
                                <p class="text-xs text-neutral-700 dark:text-neutral-300">
                                    Harga: Rp {{ number_format($book->harga_soft_setelah_diskon ?? $book->harga_soft, 0, ',', '.') }}
                                    @if(($book->diskon_soft ?? $book->diskon) > 0)
                                        <span class="text-neutral-500">(Diskon {{ $book->diskon_soft ?? $book->diskon }}%)</span>
                                    @endif
                                </p>
                            @endif
                            @unless($book->is_soft_available)
                                <p class="text-xs text-red-500">Tidak tersedia.</p>
                            @endunless
                        </div>
                    </label>
                </div>
                @error('tipe_order')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Identitas --}}
            <div class="rounded-2xl border border-neutral-200/70 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900 space-y-4">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Informasi Penerima</h4>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Nama Penerima</label>
                        <input type="text" wire:model.defer="recipient_name"
                            class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                        @error('recipient_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">No. HP Penerima</label>
                        <div class="mt-1 flex overflow-hidden rounded-lg border border-neutral-300 bg-white/80 dark:border-neutral-700 dark:bg-neutral-800">
                            <select wire:model.defer="country_code"
                                class="w-36 border-none bg-transparent px-3 py-2 text-sm font-semibold text-neutral-700 dark:text-neutral-100 focus:ring-0">
                                @foreach ($countryCodes as $item)
                                    <option value="{{ $item['code'] }}">{{ $item['label'] }} ({{ $item['code'] }})</option>
                                @endforeach
                            </select>
                            <input type="text" wire:model.defer="recipient_phone" placeholder="Nomor tanpa 0"
                                class="flex-1 border-l border-neutral-200 bg-transparent px-3 py-2 text-neutral-900 dark:border-neutral-700 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-0" />
                        </div>
                        @error('recipient_phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Email Penerima</label>
                        <input type="email" wire:model.defer="recipient_email"
                            class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                        @error('recipient_email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Label Alamat</label>
                        <input type="text" wire:model.defer="address_label" placeholder="Rumah, Kantor, dll"
                            class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                        @error('address_label')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="rounded-2xl border border-neutral-200/70 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900 space-y-4">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Alamat Pengiriman</h4>
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach (['provinsi' => 'Provinsi', 'kota' => 'Kota / Kabupaten', 'kecamatan' => 'Kecamatan', 'kelurahan' => 'Kelurahan / Desa', 'kode_pos' => 'Kode Pos'] as $field => $label)
                        <div>
                            <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">{{ $label }}</label>
                            <input type="text" wire:model.defer="{{ $field }}"
                                class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500" />
                            @error($field)<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
                <div>
                    <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Alamat Lengkap</label>
                    <textarea rows="3" wire:model.defer="alamat_lengkap"
                        class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500"></textarea>
                    @error('alamat_lengkap')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Pembayaran --}}
            <div class="rounded-2xl border border-neutral-200/70 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900 space-y-4">
                <h4 class="text-base font-semibold text-neutral-900 dark:text-neutral-50">Metode Pembayaran</h4>
                <div class="space-y-3">
                    <p class="text-sm text-neutral-600 dark:text-neutral-300">
                        Pilih metode pembayaran yang tersedia. Logo bank/ewallet di bawah ini mengikuti data yang dikelola admin.
                    </p>
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($paymentMethods as $method)
                            <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 text-sm text-neutral-700 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-lg border border-neutral-200 bg-white flex items-center justify-center dark:border-neutral-700 dark:bg-neutral-900">
                                        @if ($method->logo_path)
                                            <img src="{{ Storage::disk('public')->url($method->logo_path) }}" alt="{{ $method->name }}" class="h-full w-full object-contain p-2" />
                                        @else
                                            <span class="text-xs font-semibold text-neutral-500">Logo</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $method->name }}</p>
                                        <p class="text-xs text-neutral-500 capitalize">{{ $method->type }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-neutral-600 dark:text-neutral-300 space-y-1">
                                    @if ($method->account_number)
                                        <p>Rekening: <span class="font-semibold text-neutral-800 dark:text-neutral-100">{{ $method->account_number }}</span></p>
                                        <p>Atas nama: {{ $method->account_name ?? '-' }}</p>
                                    @endif
                                    @if ($method->instructions)
                                        <p class="text-neutral-500">{{ $method->instructions }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Pilih Metode</label>
                    <select wire:model.defer="payment_method_id"
                        class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500">
                        <option value="">Pilih metode pembayaran</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}">
                                {{ $method->name }}@if ($method->account_number) - {{ $method->account_number }} ({{ $method->account_name }})@endif
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">
                        Setelah mengirim pesanan, tim kami akan menghubungi Anda untuk konfirmasi pembayaran.
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Upload Bukti Pembayaran (Wajib)</label>
                    <input type="file" wire:model="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                        class="mt-1 block w-full text-sm text-neutral-500 file:mr-4 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-4 file:py-2 file:font-semibold file:text-cgreen-600 hover:file:bg-cgreen-100" />
                    @error('bukti_pembayaran')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    <div wire:loading wire:target="bukti_pembayaran" class="text-xs text-neutral-500 mt-1">Mengunggah bukti pembayaran...</div>
                    <p class="text-xs text-neutral-500 mt-1">Format: JPG/PNG/PDF, maksimal 20MB. Bukti akan dikirim ke admin via WhatsApp atau Email.</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Catatan untuk Admin (Opsional)</label>
                    <textarea rows="3" wire:model.defer="catatan_pengguna"
                        class="mt-1 w-full rounded-lg border-neutral-300 bg-white/80 px-3 py-2 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500"
                        placeholder="Contoh: Mohon kirimkan di jam kerja"></textarea>
                    @error('catatan_pengguna')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-neutral-500">Dengan menekan tombol kirim, Anda menyetujui untuk dihubungi tim UMRI Press.</p>
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-lg bg-cgreen-600 px-6 py-2 text-white font-semibold hover:bg-cgreen-700 disabled:opacity-60">
                    <span wire:loading.class="hidden" wire:target="submit">Kirim Pesanan</span>
                    <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>
                        Mengirim...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('open-wa-link', (event) => {
                const url = event.detail?.url;
                if (url) {
                    window.open(url, '_blank');
                }
            });
        </script>
    @endpush
@endonce
