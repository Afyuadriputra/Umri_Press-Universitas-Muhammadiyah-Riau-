<x-author-layout>
    <div class="p-6 space-y-6">
        @include('components.alert')

        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Penjualan</h2>
            <p class="text-neutral-600 dark:text-neutral-400">Daftar transaksi selesai untuk buku Anda.</p>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-sm">
                    <thead class="bg-neutral-50 dark:bg-neutral-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Buku</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Pembeli</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $sale->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-neutral-800 dark:text-neutral-100">
                                    {{ $sale->buku?->judul ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $sale->recipient_name }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    Rp {{ number_format($sale->harga_setelah_diskon, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-neutral-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-neutral-200 dark:border-neutral-700">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</x-author-layout>
