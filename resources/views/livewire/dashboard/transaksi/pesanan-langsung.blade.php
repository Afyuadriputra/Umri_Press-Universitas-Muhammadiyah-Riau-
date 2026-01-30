<div class="p-6 space-y-6">
    @include('components.alert')

    <section class="rounded-xl bg-white p-6 shadow-sm dark:bg-neutral-900">
        <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-50">Pesanan Langsung</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Pantau transaksi dari form beli langsung.</p>
            </div>

            <div class="flex w-full flex-col gap-3 md:w-auto md:flex-row">
                <input
                    type="text"
                    wire:model.debounce.400ms="search"
                    placeholder="Cari nama, email, atau judul buku"
                    class="flex-1 rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500"
                />
                <select
                    wire:model="statusFilter"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 focus:border-cgreen-500 focus:ring-cgreen-500 md:w-60"
                >
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </header>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 text-sm dark:divide-neutral-800">
                <thead class="bg-neutral-50 dark:bg-neutral-800/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-neutral-500">
                        <th class="px-4 py-3">Pesanan</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Pembayaran</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-4 align-top">
                                <p class="font-semibold text-neutral-900 dark:text-neutral-50">{{ $order->buku?->judul ?? 'Buku tidak tersedia' }}</p>
                                <p class="text-neutral-500">{{ $order->recipient_name }}</p>
                                <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    @class([
                                        'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                                        'bg-blue-100 text-blue-700' => in_array($order->status, ['verified', 'processing']),
                                        'bg-green-100 text-green-700' => in_array($order->status, ['shipped', 'completed']),
                                        'bg-red-100 text-red-700' => $order->status === 'cancelled',
                                    ])">
                                    {{ $statuses[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 align-top text-neutral-600 dark:text-neutral-300">
                                <p>{{ $order->recipient_email }}</p>
                                <p>{{ $order->recipient_phone }}</p>
                            </td>
                            <td class="px-4 py-4 align-top text-neutral-600 dark:text-neutral-300">
                                <p class="font-semibold">{{ $order->paymentMethod?->name ?? 'Metode tidak tersedia' }}</p>
                                @if ($order->paymentMethod?->account_number)
                                    <p class="text-xs text-neutral-500">
                                        {{ $order->paymentMethod->account_number }} — {{ $order->paymentMethod->account_name }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-4 align-top text-neutral-900 dark:text-neutral-50">
                                @if ($order->harga_asli !== $order->harga_setelah_diskon)
                                    <p class="text-xs text-red-500 line-through decoration-2">
                                        Rp {{ number_format($order->harga_asli, 0, ',', '.') }}
                                    </p>
                                @endif
                                <p class="font-bold">
                                    Rp {{ number_format($order->harga_setelah_diskon, 0, ',', '.') }}
                                </p>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a
                                    href="{{ route('pesananLangsung.detail', $order) }}"
                                    class="inline-flex rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-neutral-500">Belum ada pesanan langsung.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </section>

</div>
