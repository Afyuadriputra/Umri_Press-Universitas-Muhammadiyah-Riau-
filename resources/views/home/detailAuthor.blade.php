<x-main-layout>
    <section class="py-12">
        <x-container>
            <div class="max-w-5xl mx-auto bg-white dark:bg-neutral-900 rounded-2xl shadow-sm overflow-hidden p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Author Image -->
                    <div
                        class="w-32 h-32 rounded-full overflow-hidden flex-shrink-0 bg-neutral-100 dark:bg-neutral-800 border">
                        <img src="{{ $author->image ? asset($author->image) : asset('assets/img/default-person.webp') }}"
                            alt="{{ $author->name }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <!-- Author Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-100 mb-2 capitalize">{{ $author->name }}
                        </h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Bergabung sejak {{ $author->created_at->format('d M Y') }}</p>
                        <div
                            class="prose dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 text-lg mt-4 text-justify">
                            {!! nl2br(e($author->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>
</x-main-layout>
