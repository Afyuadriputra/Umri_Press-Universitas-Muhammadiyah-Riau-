<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>


    <section class="relative h-[500px] flex items-center justify-center bg-cover bg-center text-white"
        style="background-image: url('{{ asset('assets/img/bg-kirim-naskah.jpg') }}')">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative text-center px-6">
            <h1 class="text-4xl md:text-5xl font-bold">Tertarik Menjadi Penulis?</h1>
            <p class="mt-4 text-lg max-w-2xl mx-auto">Kirim Naskah ke UMRI Press Gratis! Jika Anda memiliki ide atau
                cerita yang ingin dibagikan, segera kirimkan naskah Anda.</p>
        </div>
    </section>

    <!-- Kategori Buku -->
    <section class="py-16 bg-white dark:bg-neutral-950">
        <x-container>
            <h2 class="text-4xl font-bold text-cgreen-500 text-center mb-8">Kategori Buku yang Diterbitkan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-white dark:bg-neutral-900 p-6 shadow-sm rounded-xl hover:shadow-xl transition duration-300">
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-200">Buku Ajar</h3>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Buku panduan belajar dengan struktur
                        sistematis untuk membantu
                        proses pembelajaran.</p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 shadow-sm rounded-xl hover:shadow-xl transition duration-300">
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-200">Buku Referensi</h3>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Buku ilmiah dengan informasi mendalam untuk
                        keperluan penelitian
                        dan akademik.</p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 shadow-sm rounded-xl hover:shadow-xl transition duration-300">
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-200">Buku Fiksi</h3>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Karya sastra seperti novel, cerpen, dan puisi
                        untuk menghibur dan
                        menginspirasi.</p>
                </div>
                <div
                    class="bg-white dark:bg-neutral-900 p-6 shadow-sm rounded-xl hover:shadow-xl transition duration-300">
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-200">Kategori Lainnya</h3>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Kategori buku lain yang dapat diterbitkan
                        sesuai kebutuhan dan
                        permintaan penerbit.</p>
                </div>
            </div>
        </x-container>
    </section>

    <!-- Prosedur Pengiriman Naskah -->
    <section
        class="py-20 bg-gradient-to-b from-cgreen-500 to-cgreen-700 text-white dark:from-cgreen-800 dark:to-cgreen-900">
        <x-container>
            <h2 class="text-4xl font-bold text-center mb-10">Prosedur Kirim Naskah</h2>
            <div class="max-w-4xl mx-auto bg-white dark:bg-neutral-950 p-8 rounded-xl shadow-lg text-neutral-900">
                <p class="mb-4 text-lg dark:text-neutral-200">Untuk mengirimkan naskah, pastikan naskah Anda telah
                    diketik dengan format yang
                    rapi:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2 text-neutral-700 dark:text-neutral-500">
                    <li>Gunakan font standar seperti Times New Roman ukuran 12 pt.</li>
                    <li>Panjang naskah disarankan antara 70-150 halaman A4.</li>
                    <li>Kirimkan naskah ke email yang tersedia sesuai kontak penerbit.</li>
                    <li>Format subjek email: <strong>[Kategori Buku] - Judul Buku</strong>. Contoh: <strong>BUKU AJAR -
                            "Metodologi Penelitian"</strong>.</li>
                    <li>Pastikan naskah sudah lengkap dengan bagian berikut:</li>
                </ul>
                <div class="grid grid-cols-2 gap-4">
                    <ul class="list-disc pl-6 text-neutral-700 dark:text-neutral-500">
                        <li>Kata Pengantar</li>
                        <li>Daftar Isi</li>
                        <li>Daftar Gambar & Tabel</li>
                        <li>Pendahuluan</li>
                    </ul>
                    <ul class="list-disc pl-6 text-neutral-700 dark:text-neutral-500">
                        <li>Isi Naskah</li>
                        <li>Referensi</li>
                        <li>Biografi Penulis</li>
                        <li>Glosarium (jika ada)</li>
                    </ul>
                </div>
            </div>
        </x-container>
    </section>


    <!-- Lampiran Wajib -->
    <section class="py-20 bg-gradient-to-br from-neutral-50 to-white dark:from-neutral-900 dark:to-neutral-900">
        <x-container>
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-200">Lampiran yang Diperlukan</h2>
                <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">Silakan siapkan dokumen berikut untuk
                    pengajuan naskah Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Sinopsis Card -->
                <div
                    class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900
                    dark:text-neutral-200 mb-2">
                        Sinopsis</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-4">Ringkasan isi naskah maksimal 2 halaman</p>
                </div>

                <!-- Spesifikasi Card -->
                <div
                    class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900
                    dark:text-neutral-200 mb-2">
                        Spesifikasi Buku</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-4">Formulir spesifikasi dan surat keaslian</p>
                    <a href="#"
                        class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400">
                        Unduh Form
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                </div>

                <!-- Data Diri Card -->
                <div
                    class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-900/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900
                    dark:text-neutral-200 mb-2">
                        Data Diri</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-4">Formulir identitas penulis</p>
                    <a href="#"
                        class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400">
                        Unduh Form
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                </div>

                <!-- MoU Card -->
                <div
                    class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-shadow">
                    <div
                        class="w-12 h-12 bg-orange-100 dark:bg-orange-900/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900
                    dark:text-neutral-200 mb-2">
                        MoU</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-4">MoU untuk Dosen dan Non-Dosen</p>
                    <a href="#"
                        class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400">
                        Unduh Form
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                </div>
            </div>
        </x-container>
    </section>

    <!-- Template Buku -->
    <section class="py-20">
        <x-container>
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-200">Template Buku</h2>
                <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">Pilih template sesuai dengan format buku
                    yang Anda inginkan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Template Cards -->
                <div class="group relative">
                    <div
                        class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-500">Format</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-2 dark:text-neutral-200">Ukuran A4</h3>
                        <p class="text-neutral-600 mb-2 dark:text-neutral-400">210 × 297 mm</p>
                        <ul class="text-neutral-600 mb-4 dark:text-neutral-400 list-inside space-y-1">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Jurnal
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Prosiding
                            </li>
                        </ul>
                        <a href="{{ asset($settings['template-buku-a4'] ?? '#') }}"
                            class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400 font-medium {{ !isset($settings['template-buku-a4']) ? 'cursor-not-allowed opacity-50' : '' }}"
                            @if (!isset($settings['template-buku-a4'])) onclick="event.preventDefault()" @endif download>
                            Unduh Template
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-500">Format</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-2 dark:text-neutral-200">Ukuran A5</h3>
                        <p class="text-neutral-600 mb-2 dark:text-neutral-400">148 × 210 mm</p>
                        <ul class="text-neutral-600 mb-4 dark:text-neutral-400 list-inside space-y-1">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Novel
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Kumpulan Puisi
                            </li>
                        </ul>
                        <a href="{{ asset($settings['template-buku-a5'] ?? '#') }}"
                            class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400 font-medium {{ !isset($settings['template-buku-a5']) ? 'cursor-not-allowed opacity-50' : '' }}"
                            @if (!isset($settings['template-buku-a5'])) onclick="event.preventDefault()" @endif download>
                            Unduh Template
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-500">Format</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-2 dark:text-neutral-200">UNESCO</h3>
                        <p class="text-neutral-600 mb-2 dark:text-neutral-400">165 × 250 mm</p>
                        <ul class="text-neutral-600 mb-4 dark:text-neutral-400 list-inside space-y-1">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Buku Ajar
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Buku Referensi
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Buku Monograf
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Book Chapter
                            </li>
                        </ul>
                        <a href="{{ asset($settings['template-buku-unesco'] ?? '#') }}"
                            class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400 font-medium {{ !isset($settings['template-buku-unesco']) ? 'cursor-not-allowed opacity-50' : '' }}"
                            @if (!isset($settings['template-buku-unesco'])) onclick="event.preventDefault()" @endif download>
                            Unduh Template
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>

                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="bg-white dark:bg-neutral-900 dark:border-neutral-800 p-6 rounded-2xl shadow-sm border border-neutral-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-500">Format</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-2 dark:text-neutral-200">Ukuran B5</h3>
                        <p class="text-neutral-600 mb-2 dark:text-neutral-400">176 × 250 mm</p>
                        <ul class="text-neutral-600 mb-4 dark:text-neutral-400 list-inside space-y-1">
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Buku Ajar
                            </li>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-cgreen-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Buku Referensi
                            </li>
                        </ul>
                        <a href="{{ asset($settings['template-buku-b5'] ?? '#') }}"
                            class="inline-flex items-center text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-500 dark:hover:text-cgreen-400 font-medium {{ !isset($settings['template-buku-b5']) ? 'cursor-not-allowed opacity-50' : '' }}"
                            @if (!isset($settings['template-buku-b5'])) onclick="event.preventDefault()" @endif download>
                            Unduh Template
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    @include('home.partials.kirimNaskah')

</x-main-layout>
