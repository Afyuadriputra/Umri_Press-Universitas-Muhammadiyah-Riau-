<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($articles as $article)
            <div
                class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <div class="aspect-video relative">
                    <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->judul }}"
                        class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <span
                            class="px-3 py-1 text-xs font-medium text-cgreen-500 dark:text-cgreen-400 rounded-full bg-cgreen-50 dark:bg-cgreen-900/50">
                            {{ $article->kategori->nama }}
                        </span>
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $article->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <h4 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 line-clamp-2 mb-2 capitalize">
                        {{ $article->judul }}
                    </h4>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm line-clamp-3 mb-4">
                        {!! Str::limit(strip_tags($article->konten), 150) !!}
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-neutral-200 dark:bg-neutral-700 overflow-hidden">
                                <img src="{{ asset('assets/img/default-person.webp') }}" alt="Admin">
                            </div>
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ $article->user->name }}
                            </span>
                        </div>
                        <a href="{{ route('detailArtikel', $article->slug) }}" wire:navigate
                            class="text-sm font-medium text-cgreen-500 hover:text-cgreen-600 dark:text-cgreen-400 dark:hover:text-cgreen-300">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($articles->hasPages())
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @endif
</div>
