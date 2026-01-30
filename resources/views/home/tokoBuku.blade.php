<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="bg-cgreen-500 dark:bg-cgreen-800 py-24 bg-center bg-repeat"
        style="background-image: url({{ asset('assets/img/background-buku.svg') }})">
        <x-container>
            <h1 class="text-4xl font-semibold text-white">Selamat Datang di Toko Buku UMRI Press</h1>
            <p class="mt-4 text-lg text-white">Toko Buku online terlengkap dan terpercaya dengan harga yang terjangkau
            </p>
            <div class="mt-8">
                <a href="#">
                    <x-light-button class="inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                                clip-rule="evenodd" />
                        </svg>
                        Belanja Sekarang
                    </x-light-button>
                </a>
            </div>
        </x-container>
    </section>

    <section class="pb-24">
        <x-container>
            <livewire:home.toko-buku>
        </x-container>
    </section>
</x-main-layout>
