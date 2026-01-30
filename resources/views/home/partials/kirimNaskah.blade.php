@php
    $gform = \App\Models\Pengaturan::where('key', 'gform')->first();
    $structureImage = \App\Models\Pengaturan::where('key', 'naskah_structure_image')->value('value');
@endphp
<section class="py-16 bg-white dark:bg-gray-900">
    <x-container>
        <div class="space-y-6">
            <div class="text-center lg:text-left">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Struktur Organisasi</h3>
            </div>

            <div class="relative mx-auto w-full max-w-4xl">
                @if ($structureImage)
                    <div class="overflow-hidden rounded-2xl shadow-2xl ring-2 ring-cgreen-500/30 dark:ring-cgreen-300/30">
                        <img src="{{ asset($structureImage) }}" alt="Struktur alur kirim naskah"
                            class="w-full h-auto object-contain" loading="lazy">
                    </div>
                @else
                    <div class="flex h-64 items-center justify-center rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300">
                        Belum ada gambar struktur. Upload melalui CRUD admin (key: naskah_structure_image).
                    </div>
                @endif
            </div>
        </div>
    </x-container>
</section>

<section class="py-16 bg-cgreen-500 dark:bg-cgreen-800">
    <x-container>
        <div class="text-center lg:text-left space-y-4">
            <h2 class="text-3xl font-bold text-white">Kirim Naskah Sekarang</h2>
            <p class="text-lg text-cgreen-50">Kirimkan naskah Anda dengan mudah melalui Google Form.</p>
            <a href="{{ $gform->value }}" target="_blank" class="inline-block mt-4">
                <x-light-button>
                    Kirim Sekarang
                </x-light-button>
            </a>
        </div>
    </x-container>
</section>


