<x-author-layout>
    <div class="p-6 space-y-6">
        @include('components.alert')

        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Pencairan Dana</h2>
            <p class="text-neutral-600 dark:text-neutral-400">Ajukan pencairan royalti ke rekening Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">Saldo Tersedia</h3>
                <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 mb-2">
                    Rp {{ number_format(max(0, $availableBalance), 0, ',', '.') }}
                </p>
                <p class="text-sm text-neutral-500">Minimal pencairan mengikuti kebijakan admin.</p>

                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-2">Info Rekening</h4>
                    <p class="text-sm text-neutral-600 dark:text-neutral-300">
                        {{ $author->bank_name ?? '-' }}<br>
                        {{ $author->bank_account_number ?? '-' }}<br>
                        a.n {{ $author->bank_account_name ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">Ajukan Pencairan</h3>
                <form action="{{ route('author.payouts.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label>Nominal (Rp)</x-input-label>
                        <x-text-input type="number" name="amount" min="1" class="w-full mt-1"
                            placeholder="Masukkan nominal pencairan" />
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button type="submit">Kirim Permintaan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Riwayat Pencairan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700 text-sm">
                    <thead class="bg-neutral-50 dark:bg-neutral-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Nominal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Rekening</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse ($payouts as $payout)
                            <tr>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $payout->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-neutral-800 dark:text-neutral-100">
                                    Rp {{ number_format($payout->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ strtoupper($payout->status) }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $payout->bank_details }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-neutral-500">
                                    Belum ada permintaan pencairan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-neutral-200 dark:border-neutral-700">
                {{ $payouts->links() }}
            </div>
        </div>
    </div>
</x-author-layout>
