<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <x-slot name="metaTags">
        @php
            $description = Str::limit(strip_tags($article->konten), 160);
            $keywords = $article->kategori->nama . ', ' . implode(', ', explode(' ', $article->judul));
        @endphp

        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="{{ $keywords }}">
        <meta name="author" content="{{ $article->user->name }}">
        <meta name="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
        <meta name="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
        <meta name="article:author" content="{{ $article->user->name }}">
        <meta name="article:section" content="{{ $article->kategori->nama }}">

        <meta property="og:type" content="article">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ asset($article->image) }}">
        <meta property="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
        <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
        <meta property="article:author" content="{{ $article->user->name }}">
        <meta property="article:section" content="{{ $article->kategori->nama }}">

        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ asset($article->image) }}">
        <meta name="twitter:creator" content="{{ '@' . config('app.twitter_username', 'umripress') }}">

        <link rel="canonical" href="{{ url()->current() }}" />
        <meta name="category" content="{{ $article->kategori->nama }}">
        <meta name="news_keywords" content="{{ $keywords }}">
        <meta name="rating" content="general">
        <meta name="referrer" content="no-referrer-when-downgrade">
    </x-slot>

    <section class="pb-12">
        <x-container>
            <!-- Hero Section -->
            <div class="max-w-4xl mx-auto">
                <!-- Category and Metadata -->
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span
                        class="px-3 py-1 text-xs font-semibold tracking-wider text-cgreen-600 uppercase rounded-full bg-cgreen-50 dark:bg-cgreen-900/30 dark:text-cgreen-300">
                        {{ $article->kategori->nama }}
                    </span>

                    <div class="flex items-center gap-4 text-xs text-neutral-500 dark:text-neutral-400">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $article->created_at->format('d M Y') }}
                        </span>

                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($article->views) }}
                        </span>
                    </div>
                </div>

                <!-- Title -->
                <h1
                    class="text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-neutral-900 dark:text-white mb-8 capitalize leading-tight">
                    {{ $article->judul }}
                </h1>

                <!-- Author -->
                <div class="flex items-center gap-4 mb-10">
                    <div
                        class="size-10 flex items-center justify-center rounded-full bg-neutral-200 dark:bg-neutral-700 overflow-hidden">
                        <img src="{{ asset('assets/img/default-person.webp') }}" alt="{{ $article->user->name }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-medium text-neutral-900 dark:text-neutral-100 text-sm">
                            {{ $article->user->name }}
                        </h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Author
                        </p>
                    </div>
                </div>

                <div
                    class="aspect-[16/9] rounded-xl overflow-hidden mb-12 shadow-lg bg-neutral-100 dark:bg-neutral-800">
                    <img src="{{ asset($article->image) }}" alt="{{ $article->judul }}"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Content -->
            <div class="max-w-3xl mx-auto">
                <article
                    class="prose lg:prose-lg dark:prose-invert max-w-none prose-cgreen prose-img:rounded-lg prose-headings:font-bold prose-h2:text-2xl prose-a:text-cgreen-600 dark:prose-a:text-cgreen-400">
                    {!! $article->konten !!}
                </article>

                <!-- Social Share -->
                <div class="mt-16 pt-8 border-t border-neutral-200 dark:border-neutral-800">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h4 class="text-base font-semibold text-neutral-900 dark:text-neutral-100">
                            Bagikan Artikel
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 hover:bg-blue-600 text-white transition-all hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z" />
                                </svg>
                            </a>

                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $article->judul }}"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-neutral-900 hover:bg-neutral-800 text-white transition-all hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>

                            <a href="https://wa.me/?text={{ $article->judul }}%20{{ url()->current() }}"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-500 hover:bg-green-600 text-white transition-all hover:scale-110">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>
</x-main-layout>
