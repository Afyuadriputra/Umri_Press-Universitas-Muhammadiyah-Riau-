<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ $title }}</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $isArchive ? 'Daftar surat masuk yang sudah diarsipkan.' : 'Daftar surat masuk terbaru.' }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard-surat.incoming.exportCsv', request()->query()) }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Export CSV
                </a>
                <a href="{{ route('dashboard-surat.incoming.exportPdf', request()->query()) }}" target="_blank"
                    class="inline-flex items-center gap-2 rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Export PDF
                </a>
                @unless ($isArchive)
                    <a href="{{ route('dashboard-surat.incoming.create') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-cgreen-600 px-4 py-2 text-sm font-semibold text-white hover:bg-cgreen-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Input Surat
                    </a>
                @endunless
            </div>
        </div>

        <form method="GET" class="grid gap-3 rounded-2xl border border-neutral-200 bg-white p-4 text-sm shadow-sm dark:border-neutral-700 dark:bg-neutral-900 md:grid-cols-6">
            <div class="md:col-span-2">
                <x-text-input name="search" value="{{ request('search') }}" class="w-full" placeholder="Cari nomor/perihal/pengirim" />
            </div>
            <div>
                <x-text-input name="sender" value="{{ request('sender') }}" class="w-full" placeholder="Pengirim" />
            </div>
            <div>
                <x-text-input name="subject" value="{{ request('subject') }}" class="w-full" placeholder="Perihal" />
            </div>
            <div>
                @if ($isArchive)
                    <input type="hidden" name="status" value="arsip" />
                    <div class="rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-xs font-semibold text-neutral-600 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300">
                        Status: ARSIP
                    </div>
                @else
                    <x-select name="status" class="w-full">
                        <option value="">Status</option>
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ strtoupper($status) }}</option>
                        @endforeach
                    </x-select>
                @endif
            </div>
            <div class="grid gap-2 md:col-span-2 md:grid-cols-2">
                <x-text-input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full" />
                <x-text-input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full" />
            </div>
            <div class="md:col-span-4"></div>
            <div class="flex items-center justify-end gap-2 md:col-span-2">
                <a href="{{ $isArchive ? route('dashboard-surat.incoming.archive') : route('dashboard-surat.incoming.index') }}" class="rounded-lg border border-neutral-200 px-3 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">Reset</a>
                <button type="submit" class="rounded-lg bg-cgreen-600 px-3 py-2 text-xs font-semibold text-white hover:bg-cgreen-700">Filter</button>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Agenda</th>
                            <th class="px-4 py-3 text-left font-semibold">Tanggal Terima</th>
                            <th class="px-4 py-3 text-left font-semibold">Nomor</th>
                            <th class="px-4 py-3 text-left font-semibold">Pengirim</th>
                            <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($letters as $letter)
                            <tr class="text-neutral-700 dark:text-neutral-200">
                                <td class="px-4 py-3">{{ $letter->agenda_number }}</td>
                                <td class="px-4 py-3">{{ optional($letter->received_at)->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $letter->letter_number ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $letter->sender }}</td>
                                <td class="px-4 py-3">{{ $letter->subject }}</td>
                                <td class="px-4 py-3">
                                    <x-surat-status-badge :status="$letter->status" context="incoming" />
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('dashboard-surat.incoming.show', $letter) }}"
                                            class="rounded-lg border border-neutral-200 px-2.5 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                                            Detail
                                        </a>
                                        <a href="{{ route('dashboard-surat.incoming.edit', $letter) }}"
                                            class="rounded-lg border border-neutral-200 px-2.5 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                                            Edit
                                        </a>
                                        @unless ($letter->status === 'arsip')
                                            <form method="POST" action="{{ route('dashboard-surat.incoming.archive.store', $letter) }}" onsubmit="return confirm('Arsipkan surat ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="rounded-lg bg-neutral-100 px-2.5 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700">
                                                    Arsipkan
                                                </button>
                                            </form>
                                        @endunless
                                        <form method="POST" action="{{ route('dashboard-surat.incoming.destroy', $letter) }}" onsubmit="return confirm('Hapus surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-300 dark:hover:bg-red-900/30">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                    Belum ada data surat masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4">
                {{ $letters->links() }}
            </div>
        </div>
    </div>
</x-surat-layout>
