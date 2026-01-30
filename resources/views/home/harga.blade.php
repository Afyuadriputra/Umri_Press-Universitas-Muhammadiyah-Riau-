<x-main-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <section class="pb-24">
        <x-container>
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Pilih Paket Penerbitan</h2>
                <p class="text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto">
                    Kami menyediakan berbagai paket penerbitan yang dapat disesuaikan dengan kebutuhan Anda.
                    Pilih paket yang paling sesuai dan mulai perjalanan Anda sebagai penulis bersama kami.
                </p>
            </div>

            <!-- Package Cards -->
            <div class="flex flex-wrap -mx-4">
                @foreach ($packages as $package)
                    <div class="w-full sm:w-1/2 lg:w-1/4 p-4">
                        <div
                            class="flex-shrink-0 rounded-2xl h-full {{ $package->recommended ? 'bg-cgreen-500 dark:bg-cgreen-800 px-1 pb-1 pt-2' : 'border border-neutral-200 dark:border-neutral-800' }}">
                            @if ($package->recommended)
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-white" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <p class="text-white uppercase text-xs font-semibold">RECOMMENDED</p>
                                </div>
                            @endif

                            <div
                                class="{{ $package->recommended ? 'rounded-2xl bg-cgreen-500 dark:bg-cgreen-800 border border-cgreen-300 dark:border-cgreen-400' : '' }} p-8">
                                <!-- Package Title -->
                                <p
                                    class="{{ $package->recommended ? 'text-white' : 'text-neutral-800 dark:text-neutral-200' }} text-2xl font-semibold mb-6">
                                    {{ $package->nama }}
                                </p>

                                <!-- Price -->
                                <div class="flex items-end gap-1 flex-wrap mb-4">
                                    <h2
                                        class="{{ $package->recommended ? 'text-white' : 'text-neutral-800 dark:text-neutral-100' }} text-3xl font-semibold">
                                        Rp. {{ number_format($package->harga, 0, ',', '.') }}
                                    </h2>
                                </div>

                                <!-- Copies -->
                                <p
                                    class="{{ $package->recommended ? 'text-white text-opacity-80' : 'text-neutral-600 dark:text-neutral-400' }} mb-8">
                                    {{ $package->jumlah_eksemplar }} Eksemplar
                                </p>

                                <!-- CTA Button -->
                                <a href="{{ route('daftarPenulis') }}">
                                    @if ($package->recommended)
                                        <x-light-button>Daftar Sekarang</x-light-button>
                                    @else
                                        <x-primary-button>Daftar Sekarang</x-primary-button>
                                    @endif
                                </a>

                                <!-- Divider -->
                                <div
                                    class="w-full h-px {{ $package->recommended ? 'bg-cgreen-400' : 'bg-neutral-200 dark:bg-neutral-700' }} my-8">
                                </div>

                                <!-- Features -->
                                <ul class="flex flex-col gap-3">
                                    @foreach ($package->fitur as $feature)
                                        <li class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="size-5 {{ $package->recommended ? 'text-white text-opacity-80' : 'text-neutral-400' }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span
                                                class="{{ $package->recommended ? 'text-white text-opacity-90' : 'text-neutral-600 dark:text-neutral-400' }}">
                                                {{ $feature }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-container>
    </section>
</x-main-layout>
