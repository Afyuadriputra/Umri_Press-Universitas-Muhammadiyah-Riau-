<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="pb-24">
        <x-container>
            <div class=" mb-6">
                <h2 class="text-3xl font-semibold text-neutral-900 dark:text-neutral-100">Artikel dan Berita</h2>
                <p class="text-neutral-600 dark:text-neutral-400">Berikut adalah artikel dan berita terbaru kami</p>
            </div>
            <livewire:home.artikel.index />
        </x-container>
    </section>
</x-main-layout>
