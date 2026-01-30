<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="bg-fixed bg-cover bg-center h-[500px] py-24 relative overflow-hidden flex items-center"
        style="background-image: url({{ asset('assets/img/library.jpg') }})">
        <div class="absolute inset-0 bg-black/80 z-0"></div>
        <x-container>
            <div class="z-10 relative w-full text-left">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 capitalize">
                    Ingin Kirim Naskah?
                </h1>
                <p class="max-w-xl text-neutral-100 text-pretty text-sm sm:text-base">
                    Jika Anda memiliki keahlian atau cerita yang ingin dibagikan, mengapa tidak mencoba menulis? Anda
                    sudah memiliki materi pembelajaran dan buku referensi, mengapa tidak diterbitkan? Siapa tahu Anda
                    bisa menjadi penulis besar di masa depan. Jangan ragu untuk mengirimkan naskah Anda ke UMRI Press
                    tanpa biaya!
                </p>

                <div class="mt-8 flex flex-wrap gap-4 gap-y-2 items-center">
                    <a href="{{ $settings['gform'] }}" target="_blank">
                        <x-primary-button>Daftar Sekarang</x-primary-button>
                    </a>
                    <a href="">
                        <x-secondary-button>Tampilkan Promo</x-secondary-button>
                    </a>
                </div>
            </div>
        </x-container>
    </section>


    <section class="py-16 bg-white dark:bg-neutral-950">
        <x-container>
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Mengapa Menerbitkan di UMRI Press?</h2>
                <p class="text-neutral-600 max-w-2xl mx-auto dark:text-neutral-400">Kami menyediakan layanan penerbitan
                    profesional dengan
                    standar kualitas tinggi untuk memastikan karya Anda mencapai potensi maksimalnya.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm">
                    <div
                        class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Penerbit Bereputasi</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Sebagai penerbit resmi UMRI, kami memiliki
                        kredibilitas dan pengalaman
                        dalam menerbitkan karya-karya berkualitas.</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm">
                    <div
                        class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Proses Cepat</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Kami menjamin proses penerbitan yang efisien
                        dengan timeline yang jelas dan
                        komunikasi yang responsif.</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl shadow-sm">
                    <div
                        class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Tim Profesional</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Didukung oleh tim editor dan desainer profesional
                        yang akan membantu
                        mengoptimalkan karya Anda.</p>
                </div>
            </div>
        </x-container>
    </section>

    <section class="py-16 bg-white dark:bg-neutral-950">
        <x-container>
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Proses Penerbitan</h2>
                <p class="text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">Kami menyediakan proses penerbitan
                    yang terstruktur dan
                    transparan untuk memastikan kualitas terbaik</p>
            </div>

            <div class="relative">
                <div
                    class="hidden lg:block absolute left-0 right-0 top-1/2 mt-[0.5px] h-1 bg-cgreen-200 dark:bg-cgreen-800/40 -translate-y-1/2 mx-16">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 relative">
                    <div class="relative group">
                        <div
                            class="bg-white dark:bg-neutral-900 p-8 rounded-xl shadow-sm relative z-10 h-full transform transition duration-300 hover:-translate-y-2">
                            <div
                                class="w-16 h-16 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-cgreen-600 transition-colors duration-300">
                                <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-200 group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <div
                                class="absolute -top-3 -right-3 w-8 h-8 bg-cgreen-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-lg">
                                1</div>

                            <h3 class="text-xl font-semibold text-center mb-4 text-neutral-800 dark:text-neutral-200">
                                Pengajuan Naskah</h3>
                            <p class="text-neutral-600 text-center dark:text-neutral-400">Kirimkan naskah Anda melalui
                                form pendaftaran online
                                dengan melengkapi semua persyaratan yang diperlukan</p>
                        </div>

                        <div class="hidden lg:block absolute -right-4 top-1/2 -translate-y-1/2 z-20">
                            <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-800" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M13.92 3.845a1.5 1.5 0 0 1 2.16 0l6.75 7.5a1.5 1.5 0 0 1 0 2.075l-6.75 7.5a1.5 1.5 0 0 1-2.16-2.075L18.435 14H3a1.5 1.5 0 0 1 0-3h15.435l-4.515-4.845a1.5 1.5 0 0 1 0-2.31Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="bg-white dark:bg-neutral-900 p-8 rounded-xl shadow-sm relative z-10 h-full transform transition duration-300 hover:-translate-y-2">
                            <div
                                class="w-16 h-16 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-cgreen-600 transition-colors duration-300">
                                <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-200 group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>

                            <div
                                class="absolute -top-3 -right-3 w-8 h-8 bg-cgreen-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-lg">
                                2</div>

                            <h3 class="text-xl font-semibold text-center mb-4 text-neutral-800 dark:text-neutral-200">
                                Review & Evaluasi</h3>
                            <p class="text-neutral-600 text-center dark:text-neutral-400">Tim editor kami akan melakukan
                                review menyeluruh
                                terhadap naskah untuk memastikan kualitas konten</p>
                        </div>

                        <div class="hidden lg:block absolute -right-4 top-1/2 -translate-y-1/2 z-20">
                            <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-800" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M13.92 3.845a1.5 1.5 0 0 1 2.16 0l6.75 7.5a1.5 1.5 0 0 1 0 2.075l-6.75 7.5a1.5 1.5 0 0 1-2.16-2.075L18.435 14H3a1.5 1.5 0 0 1 0-3h15.435l-4.515-4.845a1.5 1.5 0 0 1 0-2.31Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="bg-white dark:bg-neutral-900 p-8 rounded-xl shadow-sm relative z-10 h-full transform transition duration-300 hover:-translate-y-2">
                            <div
                                class="w-16 h-16 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-cgreen-600 transition-colors duration-300">
                                <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-200 group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>

                            <div
                                class="absolute -top-3 -right-3 w-8 h-8 bg-cgreen-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-lg">
                                3</div>

                            <h3 class="text-xl font-semibold text-center mb-4 text-neutral-800 dark:text-neutral-200">
                                Proses Editing</h3>
                            <p class="text-neutral-600 text-center dark:text-neutral-400">Penyuntingan bahasa, tata
                                letak, dan desain cover
                                untuk mengoptimalkan tampilan buku</p>
                        </div>

                        <div class="hidden lg:block absolute -right-4 top-1/2 -translate-y-1/2 z-20">
                            <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-800" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M13.92 3.845a1.5 1.5 0 0 1 2.16 0l6.75 7.5a1.5 1.5 0 0 1 0 2.075l-6.75 7.5a1.5 1.5 0 0 1-2.16-2.075L18.435 14H3a1.5 1.5 0 0 1 0-3h15.435l-4.515-4.845a1.5 1.5 0 0 1 0-2.31Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="bg-white dark:bg-neutral-900 p-8 rounded-xl shadow-sm relative z-10 h-full transform transition duration-300 hover:-translate-y-2">
                            <div
                                class="w-16 h-16 bg-cgreen-100 dark:bg-cgreen-800/80 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-cgreen-600 transition-colors duration-300">
                                <svg class="w-8 h-8 text-cgreen-500 dark:text-cgreen-200 group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>

                            <div
                                class="absolute -top-3 -right-3 w-8 h-8 bg-cgreen-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-lg">
                                4</div>

                            <h3 class="text-xl font-semibold text-center mb-4 text-neutral-800 dark:text-neutral-200">
                                Penerbitan</h3>
                            <p class="text-neutral-600 text-center dark:text-neutral-400">Proses cetak, ISBN, dan
                                distribusi buku ke berbagai
                                channel pemasaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    <section class="py-16 bg-cgreen-600 dark:bg-cgreen-800">
        <x-container>
            <div class="text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Siap Menerbitkan Karya Anda?</h2>
                <p class="max-w-2xl mx-auto mb-8">Jangan biarkan karya Anda hanya menjadi draft. Mari wujudkan impian
                    Anda menjadi penulis bersama UMRI Press!</p>
                <div class="flex flex-wrap justify-center gap-3 max-w-lg mx-auto">
                    <a href="{{ $settings['gform'] }}" target="_blank">
                        <x-primary-button class="!w-auto !bg-white !text-cgreen-600 hover:!shadow-white/50">
                            Kirim Sekarang
                        </x-primary-button>
                    </a>
                    <a href="https://wa.me/{{ $settings['phone'] }}" target="_blank">
                        <x-secondary-button
                            class="!w-auto !bg-transparent hover:!bg-cgreen-800/40 !shadow-none dark:hover:!bg-cgreen-900/80">
                            Hubungi Kami
                        </x-secondary-button>
                    </a>
                </div>
            </div>
        </x-container>
    </section>

</x-main-layout>
