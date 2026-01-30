<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="pb-24 bg-white dark:bg-neutral-950 mt-4">
        <x-container>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($teamMembers as $member)
                    <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                        <div class="flex flex-wrap -mx-3">
                            <!-- Profile Image -->
                            <div class="mb-4 relative w-full sm:w-1/3">
                                <img src="{{ asset($member->foto) }}" alt="{{ $member->nama }}"
                                    class="rounded-lg w-full object-cover lg:max-h-52" loading="lazy">
                            </div>

                            <div class="w-full sm:w-2/3 p-6">
                                <!-- Info -->
                                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-200 mb-1">{{ $member->nama }}</h3>
                                <p class="text-sm text-cgreen-600 dark:text-cgreen-500 font-medium mb-3">{{ $member->jabatan }}</p>
                                <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed mb-4">{{ $member->deskripsi }}</p>

                                <!-- Social Media Links -->
                                <div class="flex space-x-4 mt-4">
                                    @if ($member->facebook)
                                        <a href="{{ $member->facebook }}"
                                            class="text-neutral-400 hover:text-blue-600" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                                </path>
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($member->twitter)
                                        <a href="{{ $member->twitter }}"
                                            class="text-neutral-400 hover:text-blue-400" target="_blank">
                                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <rect width="256" height="256" fill="none" />
                                                <polygon points="48 40 96 40 208 216 160 216 48 40" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <line x1="113.88" y1="143.53" x2="48" y2="216"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="16" />
                                                <line x1="208" y1="40" x2="142.12" y2="112.47"
                                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="16" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($member->instagram)
                                        <a href="{{ $member->instagram }}"
                                            class="text-neutral-400 hover:text-pink-600" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($member->linkedin)
                                        <a href="{{ $member->linkedin }}"
                                            class="text-neutral-400 hover:text-blue-700" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-container>
    </section>

    @include('home.partials.kirimNaskah')
</x-main-layout>