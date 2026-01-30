<div class="p-6">
    @include('components.alert')
    <h2 class="text-2xl font-bold mb-6 text-neutral-900 dark:text-neutral-100">Komentar Belum Di-approve</h2>
    <div class="overflow-x-auto rounded-xl shadow-sm bg-white dark:bg-neutral-900">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
            <thead class="bg-neutral-50 dark:bg-neutral-800">
                <tr>
                    <th
                        class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase">
                        Nama</th>
                    <th
                        class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase">
                        Email</th>
                    <th
                        class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase">
                        Buku</th>
                    <th
                        class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase">
                        Tanggal</th>
                    <th
                        class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-300 uppercase">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-800">
                @forelse($comments as $comment)
                <tr>
                    <td class="px-4 py-3 font-medium text-neutral-900 dark:text-neutral-100">{{ $comment->name }}</td>
                    <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">{{ $comment->email }}</td>
                    <td class="px-4 py-3 text-cgreen-600 dark:text-cgreen-400">
                        <a href="{{ route('detailBuku', $comment->buku->slug) }}" target="_blank"
                            class="hover:underline">{{ $comment->buku->judul }}</a>
                    </td>
                    <td class="px-4 py-3 text-neutral-500 dark:text-neutral-400">{{ $comment->created_at->format('d M Y
                        H:i') }}</td>
                    <td class="px-4 py-3">
                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'show-detail-komentar')"
                            wire:click="showDetail({{ $comment->id }})"
                            class="px-3 py-1.5 bg-cgreen-500 hover:bg-cgreen-600 text-white rounded-lg text-xs font-semibold transition">Detail</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-neutral-500 dark:text-neutral-400">Tidak ada
                        komentar menunggu approval.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $comments->links() }}</div>

    <x-modal name="show-detail-komentar" :show="$showDetailModal" focusable max-width="md" align="center">
        @if ($selectedComment)
        <div class="p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-neutral-900">Detail Komentar</h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-full p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>
            <div class="mt-4">
                <p class="text-sm text-neutral-600">Nama: {{ $selectedComment->name }}</p>
                <p class="text-sm text-neutral-600">Email: {{ $selectedComment->email }}</p>
                <p class="text-sm text-neutral-600">Buku: {{ $selectedComment->buku->judul }}</p>
                <p class="text-sm text-neutral-600">Tanggal: {{ $selectedComment->created_at->format('d M Y
                    H:i') }}</p>
                <p class="text-sm text-neutral-600 mt-3">Isi Komentar: {{ $selectedComment->content }}</p>
            </div>

            {{-- tombol approve/reject --}}
            <div class="mt-6 flex justify-end gap-3">
                <x-primary-button wire:click="approveComment({{ $selectedComment->id }})">
                    {{ __('Approve') }}
                </x-primary-button>
                <x-danger-button wire:click="rejectComment({{ $selectedComment->id }})">
                    {{ __('Reject') }}
                </x-danger-button>
            </div>
        </div>
        @endif
    </x-modal>
</div>