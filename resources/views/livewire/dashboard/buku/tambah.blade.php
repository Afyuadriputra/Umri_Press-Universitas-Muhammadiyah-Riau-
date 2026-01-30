<div class="max-w-4xl mx-auto p-6">
    @include('components.alert')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
        <script src="{{ asset('js/cropper.min.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @endpush

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Tambah Buku Baru</h2>

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="block mb-2">
                        Kategori
                    </x-input-label>
                    <select wire:model="kategori_id"
                        class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                        <option value="">Pilih kategori...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Penulis
                    </x-input-label>
                    <livewire:components.searchable-select name="authors" :items="$allAuthors"
                        placeholder="Pilih author..." :selected="$authorList" :multiple="true" />
                    @error('authorList')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if (!empty($authorList))
                <div class="mt-2 rounded-lg border border-neutral-200 p-4 dark:border-neutral-700">
                    <h3 class="text-sm font-semibold text-neutral-800 dark:text-neutral-100 mb-2">
                        Royalti Penulis (%)
                    </h3>
                    <div class="space-y-3">
                        @foreach ($authorList as $authorId)
                            <div class="flex flex-col gap-2 md:flex-row md:items-center md:gap-4">
                                <div class="md:w-1/2 text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $allAuthors[$authorId] ?? 'Penulis' }}
                                </div>
                                <x-text-input type="number" min="0" max="100" step="0.01"
                                    wire:model="authorRoyalties.{{ $authorId }}"
                                    class="w-full md:w-32" placeholder="0" />
                            </div>
                        @endforeach
                    </div>
                    @error('authorRoyalties.*')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-neutral-500 mt-2">Total royalti disarankan tidak melebihi 100%.</p>
                </div>
            @endif
            <div>
                <x-input-label class="block mb-2">
                    Cover Buku (Ukuran yang disarankan: 600x900px)
                </x-input-label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 dark:border-neutral-700 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <div class="preview-container mx-auto" id="previewContainer">
                            @if ($cover)
                                <img src="{{ $cover->temporaryUrl() }}"
                                    class="w-full h-full object-cover max-w-60 mx-auto" id="previewImage">
                            @else
                                <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex text-sm text-neutral-600 justify-center">
                            <x-input-label
                                class="relative cursor-pointer rounded-md font-medium text-cgreen-600 hover:text-cgreen-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-cgreen-500">
                                <span>Upload file</span>
                                <input type="file" wire:model="cover" class="sr-only" accept="image/*" id="gambar"
                                    onchange="openCropper(event)">
                            </x-input-label>
                        </div>
                        <p class="text-xs text-neutral-500">PNG, JPG up to 2MB</p>
                    </div>
                </div>
                @error('cover')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Judul
                </x-input-label>
                <x-text-input type="text" wire:model.live="judul" class="w-full block" placeholder="Judul buku" />
                @error('judul')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Keyword / Kata Kunci
                </x-input-label>
                <x-text-input type="text" wire:model="keywords" class="w-full block"
                    placeholder="Contoh: pendidikan, bisnis, manajemen" />
                <p class="text-xs text-neutral-500 mt-1">Pisahkan dengan koma jika lebih dari satu.</p>
                @error('keywords')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Slug
                </x-input-label>
                <x-text-input type="text" wire:model="slug" class="w-full block bg-neutral-100 dark:bg-neutral-800"
                    readonly placeholder="Generated automatically" />
                @error('slug')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Abstrack
                </x-input-label>
                <div wire:ignore>
                    <div id="deskripsi" class="h-72 bg-white dark:bg-neutral-800"></div>
                </div>
                @error('deskripsi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Daftar Isi
                </x-input-label>
                <div wire:ignore>
                    <div id="daftar-isi" class="h-72 bg-white dark:bg-neutral-800"></div>
                </div>
                @error('daftar_isi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">
                    Daftar Pustaka
                </x-input-label>
                <div wire:ignore>
                    <div id="sinopsis" class="h-72 bg-white dark:bg-neutral-800"></div>
                </div>
                @error('sinopsis')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="block mb-2">
                        Institusi
                    </x-input-label>
                    <x-text-input type="text" wire:model="institusi" class="w-full block"
                        placeholder="Nama institusi (opsional)" />
                    @error('institusi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        ISBN
                    </x-input-label>
                    <x-text-input type="text" wire:model="isbn" class="block w-full"
                        placeholder="978-0-123456-47-2" />
                    @error('isbn')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        E-ISBN
                    </x-input-label>
                    <x-text-input type="text" wire:model="eisbn" class="block w-full"
                        placeholder="978-0-123456-47-2 (Digital)" />
                    @error('eisbn')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2">
                    <x-input-label class="block">Harga Hardfile</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-neutral-500 sm:text-sm">Rp</span>
                        </div>
                        <x-text-input type="number" wire:model="harga" class="pl-12 w-full block" placeholder="0" />
                    </div>
                    @error('harga')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @php
                        $hargaHard = is_numeric($harga) ? (int) $harga : null;
                        $diskonHard = is_numeric($diskon_hard) ? (int) $diskon_hard : 0;
                        $hargaHardDiskon = $hargaHard !== null ? max(0, $hargaHard - ($hargaHard * $diskonHard) / 100) : null;
                    @endphp
                    @if (!is_null($hargaHard))
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Setelah diskon: <span class="font-semibold text-cgreen-600 dark:text-cgreen-400">Rp {{ number_format($hargaHardDiskon, 0, ',', '.') }}</span>
                        </p>
                    @endif
                </div>

                <div class="space-y-2">
                    <x-input-label class="block">Harga Softfile (PDF)</x-input-label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-neutral-500 sm:text-sm">Rp</span>
                        </div>
                        <x-text-input type="number" wire:model="harga_soft" class="pl-12 w-full block" placeholder="0" />
                    </div>
                    @error('harga_soft')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @php
                        $hargaSoft = is_numeric($harga_soft) ? (int) $harga_soft : null;
                        $diskonSoft = is_numeric($diskon_soft) ? (int) $diskon_soft : 0;
                        $hargaSoftDiskon = $hargaSoft !== null ? max(0, $hargaSoft - ($hargaSoft * $diskonSoft) / 100) : null;
                    @endphp
                    @if (!is_null($hargaSoft))
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                            Setelah diskon: <span class="font-semibold text-cgreen-600 dark:text-cgreen-400">Rp {{ number_format($hargaSoftDiskon, 0, ',', '.') }}</span>
                        </p>
                    @endif
                    <p class="text-xs text-neutral-500">Wajib diisi jika softfile tersedia.</p>
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Diskon Hardfile (%)
                    </x-input-label>
                    <x-text-input type="number" wire:model="diskon_hard" min="0" max="100" class="w-full block"
                        placeholder="Contoh: 20" />
                    <p class="text-xs text-neutral-500 mt-1">Biarkan 0 bila tidak ada diskon.</p>
                    @error('diskon_hard')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Diskon Softfile (%)
                    </x-input-label>
                    <x-text-input type="number" wire:model="diskon_soft" min="0" max="100" class="w-full block"
                        placeholder="Contoh: 10" />
                    <p class="text-xs text-neutral-500 mt-1">Biarkan 0 bila tidak ada diskon.</p>
                    @error('diskon_soft')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Jumlah Halaman
                    </x-input-label>
                    <x-text-input type="number" wire:model="jumlah_halaman" class="w-full block" placeholder="100" />
                    @error('jumlah_halaman')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Stok Buku
                    </x-input-label>
                    <x-text-input type="number" wire:model="stock" class="w-full block" placeholder="0" min="0" />
                    @error('stock')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Tanggal Terbit
                    </x-input-label>
                    <x-text-input type="date" wire:model="tanggal_terbit" class="w-full block" />
                    @error('tanggal_terbit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">
                        Ukuran
                    </x-input-label>
                    <x-text-input type="text" wire:model="ukuran" class="w-full block"
                        placeholder="Contoh: 17.5 x 25 cm" />
                    @error('ukuran')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="ketersediaan"
                        class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                    <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Tersedia</span>
                </label>
            </div>

            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="is_coming_soon"
                        class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                    <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Tandai sebagai Coming Soon</span>
                </label>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Harga akan disembunyikan di toko dan diganti label "Coming Soon".</p>
            </div>

            <div class="mt-6 space-y-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Format Buku</h3>
                <div class="flex flex-col gap-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="is_hard_available"
                            class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                        <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Hardfile tersedia</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="is_soft_available"
                            class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                        <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Softfile (PDF) tersedia</span>
                    </label>
                    @error('is_soft_available')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <div class="mt-2">
                        <x-input-label class="block mb-1">Upload PDF (maks 20MB)</x-input-label>
                        <input type="file" wire:model="ebook" accept="application/pdf"
                            class="w-full text-sm text-neutral-700 dark:text-neutral-200 file:mr-4 file:rounded-full file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:file:bg-neutral-700 dark:file:text-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 rounded-lg border-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                        @error('ebook')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Wajib jika opsi softfile dicentang.</p>
                    </div>
                    <div class="mt-4">
                        <x-input-label class="block mb-1">Preview Buku (PDF, opsional)</x-input-label>
                        <input type="file" wire:model="preview_pdf" accept="application/pdf"
                            class="w-full text-sm text-neutral-700 dark:text-neutral-200 file:mr-4 file:rounded-full file:border-0 file:bg-neutral-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-neutral-700 hover:file:bg-neutral-100 dark:file:bg-neutral-700 dark:file:text-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 rounded-lg border-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                        @error('preview_pdf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Upload beberapa halaman untuk preview (maks 10MB).</p>
                        <div class="mt-2">
                            <x-input-label class="block mb-1">Jumlah Halaman Preview</x-input-label>
                            <x-text-input type="number" wire:model="preview_pages" min="1" max="50" class="w-full block" placeholder="Contoh: 5" />
                            @error('preview_pages')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-neutral-500 mt-1">Isi berapa halaman preview yang ditampilkan (maks 50).</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Link Marketplace</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Minimal pilih 1 marketplace</p>
                </div>

                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.live="marketplaces.shopee.active"
                            class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                        <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Shopee</span>
                    </label>
                    @if ($marketplaces['shopee']['active'])
                        <div>
                            <x-text-input type="url" wire:model="marketplaces.shopee.link" class="w-full block"
                                placeholder="https://shopee.co.id/product/..." />
                            @error('marketplaces.shopee.link')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.live="marketplaces.tokopedia.active"
                            class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                        <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Tokopedia</span>
                    </label>
                    @if ($marketplaces['tokopedia']['active'])
                        <div>
                            <x-text-input type="url" wire:model="marketplaces.tokopedia.link"
                                class="w-full block" placeholder="https://www.tokopedia.com/product/..." />
                            @error('marketplaces.tokopedia.link')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                @error('marketplaces')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-2 pt-4">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Pembelian Via UMRI Press</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Centang opsi berikut untuk menampilkan tombol "Beli langsung via UMRI Press" pada halaman publik.
                </p>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="allow_umri_press_payment"
                        class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                    <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Tampilkan pembayaran via UMRI Press</span>
                </label>
            </div>

            {{-- draft --}}
            <div class="mt-4">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-2">Status</h3>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="draft"
                        class="rounded border-neutral-300 text-cgreen-500 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                    <span class="ml-2 text-neutral-700 select-none dark:text-neutral-300">Simpan sebagai draft</span>
                </label>
            </div>

            <div class="flex justify-end">
                <x-primary-button type="submit">
                    Simpan Buku
                </x-primary-button>
            </div>
        </form>
    </div>

    <x-modal name="cropperModal" :show="false" maxWidth="xl" align="center">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-neutral-900">
                    {{ __('Crop Cover Image') }}
                </h2>
                <button type="button" class="text-neutral-400 hover:text-neutral-500" onclick="closeCropModal()">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-4 bg-neutral-50 rounded-lg">
                <img id="cropImage" src="" alt="Gambar untuk dipotong">
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <x-border-button type="button" class="!w-auto" onclick="closeCropModal()">
                    {{ __('Cancel') }}
                </x-border-button>
                <x-primary-button type="button" class="!w-auto" onclick="cropImage()">
                    {{ __('Crop & Save') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    @push('scripts')
        <script>
            window.ImageCropperManager = {
                cropper: null,
                originalFile: null,

                initCropper() {
                    window.openCropper = (event) => {
                        this.originalFile = event.target.files[0];

                        if (!this.originalFile) return;

                        const reader = new FileReader();

                        reader.onload = (e) => {
                            const image = document.getElementById('cropImage');
                            image.src = e.target.result;

                            if (this.cropper) {
                                this.cropper.destroy();
                            }

                            image.onload = () => {
                                this.cropper = new Cropper(image, {
                                    aspectRatio: 2 / 3,
                                    viewMode: 1,
                                    dragMode: 'move',
                                    autoCropArea: 0.8,
                                    restore: false,
                                    guides: true,
                                    center: true,
                                    highlight: true,
                                    cropBoxMovable: true,
                                    cropBoxResizable: true,
                                    toggleDragModeOnDblclick: false,
                                    minContainerWidth: 600,
                                    minContainerHeight: 600
                                });

                                @this.dispatch('open-modal', 'cropperModal');
                            };
                        };

                        reader.readAsDataURL(this.originalFile);
                        event.target.value = '';
                    };

                    window.cropImage = () => {
                        if (!this.cropper) return;

                        const generateImage = (width, height, quality = 0.9) => {
                            return new Promise((resolve) => {
                                const canvas = this.cropper.getCroppedCanvas({
                                    width: width,
                                    height: height,
                                    imageSmoothingEnabled: true,
                                    imageSmoothingQuality: 'high',
                                });

                                canvas.toBlob((blob) => {
                                    const file = new File([blob],
                                        `${this.originalFile.name.split('.')[0]}_${width}x${height}.jpg`, {
                                            type: 'image/jpeg'
                                        });
                                    resolve(file);
                                }, 'image/jpeg', quality);
                            });
                        };

                        Promise.all([
                            generateImage(300, 450, 0.7),
                            generateImage(600, 900, 0.9)
                        ]).then(([thumbnailFile, fullSizeFile]) => {
                            @this.upload('cover', fullSizeFile,
                                (uploadedFilename) => {
                                    @this.upload('thumbnail', thumbnailFile,
                                        (thumbnailFilename) => {
                                            const previewImage = document.getElementById(
                                                'previewImage');
                                            if (previewImage) {
                                                previewImage.src = URL.createObjectURL(thumbnailFile);
                                            }

                                            window.dispatchEvent(new CustomEvent('close-modal', {
                                                detail: 'cropperModal'
                                            }));

                                            this.cleanup();
                                        },
                                        (error) => {
                                            console.error('Thumbnail upload failed:', error);
                                            alert('Failed to upload thumbnail. Please try again.');
                                        }
                                    );
                                },
                                (error) => {
                                    console.error('Cover upload failed:', error);
                                    alert('Failed to upload cover image. Please try again.');
                                }
                            );
                        });
                    };

                    window.closeCropModal = () => {
                        this.cleanup();
                        window.dispatchEvent(new CustomEvent('close-modal', {
                            detail: 'cropperModal'
                        }));
                    };
                },

                cleanup() {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }

                    const cropImage = document.getElementById('cropImage');
                    if (cropImage) {
                        cropImage.src = '';
                    }
                }
            };

            window.ImageCropperManager.initCropper();

            document.addEventListener('livewire:navigated', () => {
                window.ImageCropperManager.initCropper();
            });

            document.addEventListener('livewire:navigating', () => {
                window.ImageCropperManager.cleanup();
            });
        </script>

        <script>
            window.EditorManager = {
                editors: {},

                init() {
                    if (typeof Quill === 'undefined') {
                        setTimeout(() => this.init(), 100);
                        return;
                    }

                    if (!document.getElementById('deskripsi') ||
                        !document.getElementById('sinopsis') ||
                        !document.getElementById('daftar-isi')) {
                        setTimeout(() => this.init(), 100);
                        return;
                    }

                    const wireEl = document.querySelector('[wire\\:id]');
                    if (!wireEl) {
                        console.warn('No Livewire component found');
                        return;
                    }

                    const component = Livewire.find(wireEl.getAttribute('wire:id'));
                    if (!component) {
                        console.warn('Could not find Livewire component instance');
                        return;
                    }

                    const quillConfig = {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'header': [1, 2, 3, 4, 5, 6, false]
                                }],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                ['clean']
                            ]
                        },
                        placeholder: 'Tulis konten disini...'
                    };

                    if (!this.editors.deskripsi) {
                        this.initializeEditor('deskripsi', quillConfig, component);
                    }
                    if (!this.editors.sinopsis) {
                        this.initializeEditor('sinopsis', quillConfig, component);
                    }
                    if (!this.editors['daftar-isi']) {
                        this.initializeEditor('daftar-isi', quillConfig, component);
                    }
                },

                initializeEditor(id, config, component) {
                    const element = document.getElementById(id);
                    if (!element) return;

                    const existingToolbar = element.parentNode.querySelector('.ql-toolbar');
                    if (existingToolbar) {
                        existingToolbar.remove();
                    }

                    const editor = new Quill(`#${id}`, config);

                    editor.on('text-change', () => {
                        const content = editor.root.innerHTML.trim();
                        component.dispatch('set-' + id, {
                            content
                        });
                    });

                    this.editors[id] = editor;
                },

                cleanup() {
                    Object.values(this.editors).forEach(editor => {
                        if (editor && editor.container) {
                            const parent = editor.container.parentNode;
                            if (parent) {
                                const toolbar = parent.querySelector('.ql-toolbar');
                                if (toolbar) toolbar.remove();
                            }
                        }
                    });
                    this.editors = {};
                }
            };

            document.addEventListener('livewire:initialized', () => {
                setTimeout(() => window.EditorManager.init(), 100);
            });

            document.addEventListener('livewire:navigating', () => window.EditorManager.cleanup());
            document.addEventListener('livewire:navigated', () => {
                setTimeout(() => window.EditorManager.init(), 100);
            });
        </script>
    @endpush
</div>
