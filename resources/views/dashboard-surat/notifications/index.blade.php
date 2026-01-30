<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Notifikasi Surat</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Pemberitahuan terkait disposisi dan persetujuan.</p>
        </div>

        <div class="space-y-4">
            @forelse ($notifications as $notification)
                <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                                {{ $notification->title }}
                            </p>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $notification->body ?? '-' }}
                            </p>
                            <p class="mt-2 text-xs text-neutral-500">
                                {{ $notification->created_at->format('d M Y H:i') }}
                            </p>
                            <div class="mt-2">
                                @if ($notification->read_at)
                                    <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-semibold text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">DIBACA</span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">BELUM DIBACA</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($notification->link)
                                <a href="{{ $notification->link }}"
                                    class="rounded-lg border border-neutral-200 px-3 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                                    Buka
                                </a>
                            @endif
                            @if (! $notification->read_at)
                                <form method="POST" action="{{ route('dashboard-surat.notifications.read', $notification) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="rounded-lg bg-cgreen-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-cgreen-700">
                                        Tandai dibaca
                                    </button>
                                </form>
                            @else
                                <span class="text-xs font-semibold text-neutral-400">Sudah dibaca</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-neutral-300 bg-white/60 p-6 text-center text-neutral-500 dark:border-neutral-700 dark:bg-neutral-800/60">
                    Tidak ada notifikasi.
                </div>
            @endforelse
        </div>

        <div>
            {{ $notifications->links() }}
        </div>
    </div>
</x-surat-layout>
