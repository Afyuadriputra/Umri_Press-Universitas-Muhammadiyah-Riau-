<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Disposisi Saya</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Daftar disposisi yang ditujukan kepada Anda.</p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold">Surat</th>
                            <th class="px-4 py-3 text-left font-semibold">Instruksi</th>
                            <th class="px-4 py-3 text-left font-semibold">Due Date</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($dispositions as $disposition)
                            <tr class="text-neutral-700 dark:text-neutral-200">
                                <td class="px-4 py-3">{{ $disposition->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('dashboard-surat.incoming.show', $disposition->incoming_letter_id) }}"
                                        class="text-cgreen-600 hover:underline">
                                        {{ $disposition->incomingLetter?->subject ?? 'Surat' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ $disposition->instruction ?? '-' }}</td>
                                <td class="px-4 py-3">{{ optional($disposition->due_date)->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <x-surat-status-badge :status="$disposition->status" context="disposisi" />
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('dashboard-surat.disposisi.update', $disposition) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <x-select name="status" class="w-32">
                                            <option value="baru" @selected($disposition->status === 'baru')>BARU</option>
                                            <option value="diproses" @selected($disposition->status === 'diproses')>DIPROSES</option>
                                            <option value="selesai" @selected($disposition->status === 'selesai')>SELESAI</option>
                                        </x-select>
                                        <button type="submit" class="rounded-lg bg-cgreen-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-cgreen-700">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                    Belum ada disposisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4">
                {{ $dispositions->links() }}
            </div>
        </div>
    </div>
</x-surat-layout>
