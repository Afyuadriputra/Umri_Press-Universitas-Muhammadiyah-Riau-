<x-app-layout>
    <div class="p-6 space-y-6">
        @include('components.alert')

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Pencairan Penulis</h2>
                <p class="text-neutral-500 dark:text-neutral-400">Kelola status permintaan pencairan.</p>
            </div>
        </div>

        <form method="GET" class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status</label>
                    <select name="status"
                        class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                        <option value="">Semua</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                        <option value="paid" @selected(request('status') === 'paid')>Paid</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Penulis</label>
                    <x-text-input type="text" name="author" value="{{ request('author') }}" placeholder="Nama penulis" class="w-full" />
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <a href="{{ route('dashboard.payouts.index') }}" class="text-sm text-neutral-500 hover:text-neutral-700">
                    Reset
                </a>
                <x-primary-button type="submit">Filter</x-primary-button>
            </div>
        </form>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-neutral-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Nominal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Rekening</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 text-sm">
                        @forelse ($payouts as $payout)
                            <tr>
                                <td class="px-6 py-4 text-neutral-600 dark:text-neutral-300">
                                    {{ $payout->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-neutral-800 dark:text-neutral-100">
                                    {{ $payout->author?->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-neutral-800 dark:text-neutral-100">
                                    Rp {{ number_format($payout->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-neutral-600 dark:text-neutral-300">
                                    {{ $payout->bank_details }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $payout->status === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-800/20 dark:text-green-400' : '' }}
                                        {{ $payout->status === 'paid' ? 'bg-blue-100 text-blue-700 dark:bg-blue-800/20 dark:text-blue-400' : '' }}
                                        {{ $payout->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-800/20 dark:text-amber-400' : '' }}">
                                        {{ strtoupper($payout->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('dashboard.payouts.update', $payout) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                            class="rounded-lg border-neutral-300 text-xs dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                                            <option value="pending" @selected($payout->status === 'pending')>Pending</option>
                                            <option value="approved" @selected($payout->status === 'approved')>Approved</option>
                                            <option value="paid" @selected($payout->status === 'paid')>Paid</option>
                                        </select>
                                        <x-primary-button type="submit" class="!py-1 !px-3 !text-xs">Simpan</x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-neutral-500">Belum ada pencairan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
                {{ $payouts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
