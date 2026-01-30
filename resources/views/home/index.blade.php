<x-main-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/dist/splide/splide.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/dist/splide/splide.min.js') }}"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
        </script>
        <script>
            function initializeSplide() {
                let banner = document.querySelector('#banner');
                let supportSlider = document.querySelector('#support-slider');

                if (typeof Splide === 'undefined') {
                    setTimeout(initializeSplide, 50);
                    return;
                }

                if (window.splideBanner) {
                    window.splideBanner.destroy();
                }

                if (banner) {
                    window.splideBanner = new Splide(banner, {
                        type: 'fade',
                        rewind: true,
                        autoplay: true,
                        interval: 5000,
                        arrows: false,
                        pagination: true,
                        pauseOnHover: false,
                    }).mount();
                }
            }

            document.addEventListener('DOMContentLoaded', initializeSplide);
            document.addEventListener('livewire:navigated', initializeSplide);
        </script>
    @endpush

    <x-slot name="title">{{ $title }}</x-slot>

    <section>
        <div id="banner" class="splide" aria-label="Banner Slides">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide relative h-screen">
                        <div class="absolute inset-0">
                            <img src="{{ asset('assets/img/banner/universitas.jpg') }}" alt="Banner 1"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/30"></div>
                        <div class="relative h-full max-w-7xl mx-auto px-4 lg:px-8 flex items-center">
                            <div class="max-w-2xl">
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 uppercase">
                                    Selamat datang di UMRI Press
                                </h1>
                                <p class="text-lg text-neutral-200 mb-8">
                                    UMRI Press adalah penerbit resmi Universitas Muhammadiyah Riau (UMRI) yang
                                    berdedikasi untuk memajukan dunia literasi melalui penerbitan karya-karya terbaik.
                                    Kami berkomitmen untuk menjadi mitra utama dalam menyebarkan pengetahuan, mendukung
                                    penelitian, serta mengembangkan karya-karya akademik dan non-akademik yang
                                    bermanfaat bagi masyarakat.
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="splide__slide relative h-screen">
                        <div class="absolute inset-0">
                            <img src="{{ asset('assets/img/banner/fotoumri3.jpeg') }}" alt="Banner 2"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/30"></div>
                        <div class="relative h-full max-w-7xl mx-auto px-4 lg:px-8 flex items-center">
                            <div class="max-w-2xl">
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 uppercase">
                                    UNIVERSITAS MUHAMMADIYAH RIAU
                                </h1>
                                <p class="text-lg text-neutral-200 mb-8">
                                    Universitas Muhammadiyah Riau (UMRI) adalah sebuah perguruan tinggi swasta yang
                                    berlokasi di Pekanbaru, Riau. UMRI didirikan oleh Persyarikatan Muhammadiyah dan
                                    berkomitmen untuk menyelenggarakan pendidikan tinggi berbasis nilai-nilai Islam.
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="splide__slide relative h-screen">
                        <div class="absolute inset-0">
                            <img src="{{ asset('assets/img/banner/univumri.jpg') }}" alt="Banner 3"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/30"></div>
                        <div class="relative h-full max-w-7xl mx-auto px-4 lg:px-8 flex items-center">
                            <div class="max-w-2xl">
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 uppercase">
                                    Apa itu Press?
                                </h1>
                                <p class="text-lg text-neutral-200 mb-8">
                                    University Press atau Penerbit Universitas adalah lembaga penerbitan akademik yang
                                    dikelola oleh universitas untuk menerbitkan buku, jurnal, dan penelitian ilmiah.
                                    Penerbit ini berfokus pada publikasi akademik, termasuk karya ilmiah dosen,
                                    mahasiswa, dan peneliti yang berkaitan dengan berbagai disiplin ilmu. </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    @php
        $certificateData = $certificates->map(fn($c) => [
            'id' => $c->id,
            'title' => $c->title,
            'description' => $c->description,
            'url' => asset($c->file_path),
            'preview' => $c->preview_image ? asset($c->preview_image) : null,
        ])->values();
    @endphp
    <section class="py-16 bg-gradient-to-b from-white via-white to-cgreen-50/40 dark:from-neutral-900 dark:via-neutral-900 dark:to-neutral-800">
        <x-container>
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-base font-semibold text-cgreen-600 tracking-wide uppercase">Sertifikat</h2>
                <h3 class="mt-2 text-3xl font-bold text-neutral-900 sm:text-4xl dark:text-neutral-100">
                    Sertifikat & Kerja Sama UMRI Press
                </h3>
                <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
                    Koleksi penghargaan dan nota kesepahaman yang menegaskan kepercayaan mitra terhadap UMRI Press.
                </p>
            </div>

            @if ($certificates->isEmpty())
                <div class="rounded-2xl border border-dashed border-neutral-300 bg-white/60 p-8 text-center shadow-sm dark:border-neutral-700 dark:bg-neutral-800/60">
                    <p class="text-neutral-600 dark:text-neutral-300">Belum ada sertifikat yang ditambahkan.</p>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 justify-items-center justify-center max-w-3xl mx-auto">
                    @foreach ($certificates as $certificate)
                        <div class="w-full max-w-xs text-center">
                            <a href="{{ asset($certificate->file_path) }}" target="_blank" rel="noopener noreferrer" class="block">
                                <div class="inline-flex items-center justify-center rounded-lg border border-neutral-200 bg-neutral-50 p-3 shadow-sm overflow-hidden dark:border-neutral-700 dark:bg-neutral-950">
                                    @if ($certificate->preview_image)
                                        <img src="{{ asset($certificate->preview_image) }}" alt="{{ $certificate->title }}"
                                            class="h-auto w-full object-contain" loading="lazy" />
                                    @else
                                        <object data="{{ asset($certificate->file_path) }}#page=1&view=FitH&zoom=page-fit"
                                            type="application/pdf" class="w-full pointer-events-none" style="height: 12rem;" aria-label="Pratinjau sertifikat">
                                        </object>
                                    @endif
                                </div>
                            </a>
                            <div class="mt-3">
                                <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 line-clamp-2">
                                    {{ $certificate->title }}
                                </p>
                                @if ($certificate->description)
                                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400 line-clamp-2">
                                        {{ $certificate->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-container>
    </section>

    <section class="py-24 bg-neutral-50 dark:bg-neutral-950">
        <x-container>
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-base font-semibold text-cgreen-500 tracking-wide uppercase">Tentang Press UMRI</h2>
                <h3 class="mt-2 text-3xl font-bold text-neutral-900 sm:text-4xl dark:text-neutral-200">Mendukung
                    Publikasi Ilmiah Berkualitas
                </h3>
                <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">Penerbit akademik yang berdedikasi untuk
                    menyebarluaskan
                    pengetahuan melalui publikasi karya ilmiah berkualitas tinggi.</p>
            </div>

            <div class="grid sm:grid-cols-2 gap-6 md:grid-cols-3 mb-16">
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Penerbitan Buku</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Layanan penerbitan buku akademik dan
                        non-akademik dengan
                        standar kualitas tinggi</dd>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Pengiriman Naskah</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Proses pengiriman dan review naskah yang
                        efisien dan
                        profesional</dd>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Jasa Parafrase</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Layanan parafrase profesional untuk
                        meningkatkan kualitas
                        tulisan akademik</dd>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Konsultasi Penulisan</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Bimbingan dan konsultasi untuk
                        mengembangkan keterampilan
                        menulis akademik</dd>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Toko Buku</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Koleksi lengkap buku akademik dan
                        referensi ilmiah berkualitas
                    </dd>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm shadow-neutral-200 dark:shadow-neutral-800 dark:hover:shadow-cgreen-800/60 dark:hover:shadow-lg hover:shadow-xl duration-500">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <dt class="text-2xl font-bold capitalize dark:text-neutral-200">Distribusi</dt>
                    </div>
                    <dd class="text-sm text-neutral-600 dark:text-neutral-500">Layanan distribusi dan pemasaran buku ke
                        berbagai jaringan
                        toko buku</dd>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <img src="{{ asset('assets/img/banner/universitas.jpg') }}" alt="Press Publishing"
                        class="rounded-2xl shadow-lg w-full h-[500px] object-cover">
                </div>

                <div class="space-y-6">
                    <div class="space-y-4">
                        <span
                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-cgreen-500 dark:text-cgreen-400 rounded-full bg-cgreen-50 dark:bg-cgreen-900/50">
                            Layanan Kami
                        </span>
                        <h4 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-200">Mendukung Publikasi
                            Akademik Berkualitas
                        </h4>
                        <p class="text-neutral-600 dark:text-neutral-400">Kami menyediakan platform publikasi yang
                            kcgreenibel untuk karya
                            ilmiah, buku akademik, dan jurnal penelitian dengan standar mutu internasional.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-cgreen-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg font-medium text-neutral-900 dark:text-neutral-200">Penerbitan
                                    Berkualitas</h5>
                                <p class="mt-1 text-neutral-600 dark:text-neutral-500">Penerbitan karya ilmiah
                                    berkualitas tinggi</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-cgreen-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg font-medium text-neutral-900 dark:text-neutral-200">
                                    Mendukung Dunia Pendidikan</h5>
                                <p class="mt-1 text-neutral-600 dark:text-neutral-500">
                                    Mendukung dunia pendidikan dengan publikasi karya ilmiah yang bermanfaat
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-cgreen-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h5 class="text-lg font-medium text-neutral-900 dark:text-neutral-200">Inovasi dan
                                    Keunggulan</h5>
                                <p class="mt-1 text-neutral-600 dark:text-neutral-500">Inovasi dan keunggulan dalam
                                    penerbitan karya ilmiah
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="{{ $settings['gform'] }}" target="_blank"
                            class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-cgreen-500 rounded-lg hover:bg-cgreen-600 transition-colors duration-300">
                            Kirim Naskah
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    <section class="py-24 bg-white dark:bg-neutral-900">
        <x-container>

            <div class="mb-20">
                <div class="flex flex-wrap gap-4 justify-between items-end mb-8">
                    <div>
                        <h2 class="text-base font-semibold text-cgreen-500 tracking-wide uppercase">Buku Terbaru</h2>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-200">Koleksi Terbaru Kami
                        </h3>
                    </div>
                    <a href="{{ route('tokoBuku') }}" wire:navigate
                        class="text-cgreen-500 hover:text-cgreen-600 dark:text-cgreen-400 dark:hover:text-cgreen-300 font-medium inline-flex items-center gap-2">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div>
                    <livewire:home.buku-terbaru />
                </div>
            </div>


            @empty(!$latestArticles->count())
                <div>
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 class="text-base font-semibold text-cgreen-500 tracking-wide uppercase">Artikel Terbaru
                            </h2>
                            <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-200">Artikel & Berita
                                Terkini</h3>
                        </div>
                        <a href="{{ route('artikel') }}" wire:navigate
                            class="text-cgreen-500 hover:text-cgreen-600 dark:text-cgreen-400 dark:hover:text-cgreen-300 font-medium inline-flex items-center gap-2">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($latestArticles as $article)
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
                                    <h4
                                        class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 line-clamp-2 mb-2 capitalize">
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
                </div>
            @endempty
        </x-container>
    </section>

    @include('home.partials.kirimNaskah')
</x-main-layout>
