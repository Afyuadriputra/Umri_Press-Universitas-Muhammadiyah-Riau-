<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="pb-24">
        <x-container>
            <div class="w-full h-[400px] relative ">
                <div>
                    <iframe class="w-full h-[400px] rounded-2xl dark:hidden"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2372.2701449108686!2d101.41675830115904!3d0.4991411561016821!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a940e01df989%3A0xdc96c279c6f07bc3!2sUniversitas%20Muhammadiyah%20Riau!5e0!3m2!1sid!2sid!4v1739789350646!5m2!1sid!2sid"style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div>
                    <iframe class="w-full h-[400px] rounded-2xl google-maps hidden dark:block"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2372.2701449108686!2d101.41675830115904!3d0.4991411561016821!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a940e01df989%3A0xdc96c279c6f07bc3!2sUniversitas%20Muhammadiyah%20Riau!5e0!3m2!1sid!2sid!4v1739789350646!5m2!1sid!2sid"style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">
                <div class="space-y-8 max-w-lg">
                    <h2 class="text-3xl font-bold mb-8">Hubungi Kami</h2>

                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-cgreen-100 dark:bg-cgreen-900/80 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-cgreen-600 dark:text-cgreen-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Alamat</h3>
                            <p class="text-neutral-600 dark:text-neutral-400">
                                {{ $settings['address'] ?? 'Jl. Tuanku Tambusai, Delima, Kec. Tampan, Kota Pekanbaru, Riau 28290' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/80 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">WhatsApp</h3>
                            @php
                                $phone = preg_replace('/[^0-9]/', '', $settings['phone'] ?? '628783715150');
                            @endphp
                            <a href="https://wa.me/{{ $phone }}" target="_blank"
                                class="text-neutral-600 hover:text-green-600 dark:text-neutral-400 dark:hover:text-green-500">
                                {{ $settings['phone'] ?? '+62 878-3715-1510' }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/80 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Email</h3>
                            <a href="mailto:{{ $settings['email'] ?? 'umripres@umri.ac.id' }}"
                                class="text-neutral-600 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-blue-500">
                                {{ $settings['email'] ?? 'umripres@umri.ac.id' }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-8">
                    <h3 class="text-2xl font-semibold mb-6">Kirim Pesan</h3>
                    <form onsubmit="sendToWhatsApp(event)" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm text-neutral-700 dark:text-neutral-200 mb-2">Nama
                                Lengkap</label>
                            <input type="text" id="name" name="name" autocomplete="off"
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-900 dark:border-neutral-800 outline-none shadow-none rounded-lg border border-neutral-200 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-200 transition-colors"
                                requicgreen>
                        </div>

                        <div>
                            <label for="email"
                                class="block text-sm text-neutral-700 dark:text-neutral-200 mb-2">Email</label>
                            <input type="email" id="email" name="email" autocomplete="off"
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-900 dark:border-neutral-800 outline-none shadow-none rounded-lg border border-neutral-200 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-200 transition-colors"
                                requicgreen>
                        </div>

                        <div>
                            <label for="subject"
                                class="block text-sm text-neutral-700 dark:text-neutral-200 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" autocomplete="off"
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-900 dark:border-neutral-800 outline-none shadow-none rounded-lg border border-neutral-200 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-200 transition-colors"
                                requicgreen>
                        </div>

                        <div>
                            <label for="message"
                                class="block text-sm text-neutral-700 dark:text-neutral-200 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5"
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-900 dark:border-neutral-800 outline-none shadow-none rounded-lg border border-neutral-200 focus:border-cgreen-500 focus:ring-2 focus:ring-cgreen-200 transition-colors"
                                requicgreen></textarea>
                        </div>

                        <button type="submit"
                            class="px-6 py-3 bg-cgreen-500 text-white rounded-lg hover:bg-cgreen-600 transition-colors">
                            Kirim Pesan
                        </button>
                    </form>

                </div>
            </div>
        </x-container>
    </section>

    @push('scripts')
        <script>
            function sendToWhatsApp(event) {
                event.preventDefault();

                let name = document.getElementById("name").value;
                let email = document.getElementById("email").value;
                let subject = document.getElementById("subject").value;
                let message = document.getElementById("message").value;

                let text = `Halo, saya ${name}%0AEmail: ${email}%0ASubjek: ${subject}%0APesan: ${message}`;

                let phone = "{{ preg_replace('/[^0-9]/', '', $settings['phone'] ?? '628783715150') }}";

                let url = `https://wa.me/${phone}?text=${text}`;
                window.open(url, "_blank");
            }
        </script>
    @endpush
</x-main-layout>
