<x-author-layout>
    <div class="p-6 space-y-6">
        @include('components.alert')

        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Dashboard Royalti</h2>
            <p class="text-neutral-600 dark:text-neutral-400">Ringkasan performa dan saldo royalti Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-neutral-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-neutral-500">Saldo Tersedia</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    Rp {{ number_format(max(0, $availableBalance), 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-neutral-500">Total Dicairkan</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    Rp {{ number_format($totalPaid, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
                <div class="p-5 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Tren Pendapatan Bulanan</h3>
                </div>
                <div class="p-5 space-y-3">
                    @forelse ($monthlySales as $row)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ $row->month }}</span>
                            <span class="font-semibold text-neutral-900 dark:text-neutral-100">
                                Rp {{ number_format($row->total, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">Belum ada data pendapatan.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
                <div class="p-5 border-b border-neutral-200 dark:border-neutral-700">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Transaksi Terbaru</h3>
                </div>
                <div class="p-5 space-y-3">
                    @forelse ($recentTransactions as $trx)
                        <div class="flex items-start justify-between gap-3 text-sm">
                            <div>
                                <p class="text-neutral-800 dark:text-neutral-100">
                                    {{ $trx->description ?? ucfirst($trx->type) }}
                                </p>
                                <p class="text-xs text-neutral-500">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold {{ $trx->type === 'credit' ? 'text-cgreen-600' : 'text-red-500' }}">
                                    {{ $trx->type === 'credit' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-neutral-500">{{ strtoupper($trx->status) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
            <div class="p-5 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Buku Saya</h3>
            </div>
            <div class="p-5 overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-sm">
                    <thead class="bg-neutral-50 dark:bg-neutral-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Terjual</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse ($books as $book)
                            <tr>
                                <td class="px-4 py-3 text-neutral-800 dark:text-neutral-100">
                                    {{ $book->judul }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $book->completed_orders_count ?? 0 }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    Rp {{ number_format($book->completed_revenue ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-neutral-500">Belum ada buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-author-layout>
