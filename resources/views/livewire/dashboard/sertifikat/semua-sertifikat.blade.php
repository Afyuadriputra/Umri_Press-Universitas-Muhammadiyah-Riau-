<div class="p-6">
    @include('components.alert')

    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Sertifikat Kerja Sama</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Kelola daftar sertifikat yang ditampilkan di halaman utama.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-2">
            <x-text-input type="text" wire:model.live.debounce.300ms="search" class="w-full sm:w-64"
                placeholder="Cari sertifikat..." />
            <x-primary-button type="button" wire:click="openCreate" class="!w-auto inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Sertifikat
            </x-primary-button>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm">
        <div class="border-b border-neutral-200 dark:border-neutral-700 px-6 py-3 text-sm text-neutral-500 dark:text-neutral-400">
            Seret titik tiga di kiri kartu untuk mengatur urutan tampil.
        </div>

        <div class="p-6">
            @if ($certificates->isEmpty())
                <div class="rounded-lg border border-dashed border-neutral-300 dark:border-neutral-700 p-6 text-center text-neutral-500 dark:text-neutral-400">
                    Belum ada sertifikat. Klik "Tambah Sertifikat" untuk mulai menambahkan.
                </div>
            @else
                <div wire:sortable="updateOrder" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($certificates as $certificate)
                        <div wire:sortable.item="{{ $certificate->id }}" wire:key="cert-{{ $certificate->id }}"
                            class="rounded-xl border border-neutral-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-neutral-700 dark:bg-neutral-800">
                            <div class="flex items-start gap-3 p-4">
                                <div wire:sortable.handle class="mt-1 cursor-move text-neutral-400">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8h16M4 16h16" />
                                    </svg>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-wide text-neutral-400 dark:text-neutral-500">
                                                Urutan {{ $certificate->position }}
                                            </p>
                                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                                                {{ $certificate->title }}
                                            </h3>
                                        </div>
                                        <span class="rounded-full bg-cgreen-50 px-3 py-1 text-xs font-semibold text-cgreen-700 dark:bg-cgreen-900/30 dark:text-cgreen-300">
                                            PDF
                                        </span>
                                    </div>
                                    @if ($certificate->description)
                                        <p class="text-sm text-neutral-600 line-clamp-3 dark:text-neutral-400">
                                            {{ $certificate->description }}
                                        </p>
                                    @endif
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        <a href="{{ asset($certificate->file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1 rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-200 dark:bg-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Lihat PDF
                                        </a>
                                        <button type="button" wire:click="openEdit({{ $certificate->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg border border-neutral-200 px-3 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:text-neutral-200 dark:hover:bg-neutral-700">
                                            Edit
                                        </button>
                                        <button type="button" wire:click="confirmDelete({{ $certificate->id }})"
                                            class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-300 dark:hover:bg-red-900/30">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>

    <x-modal name="certificate-form" :show="false" maxWidth="3xl">
        <form wire:submit.prevent="save" class="p-6 space-y-4">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                {{ $certificateId ? 'Edit Sertifikat' : 'Tambah Sertifikat' }}
            </h3>

            <div class="space-y-3">
                <div>
                    <x-input-label class="block mb-1">Judul</x-input-label>
                    <x-text-input type="text" wire:model.defer="title" class="w-full" placeholder="Judul sertifikat" />
                    @error('title') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-input-label class="block mb-1">Deskripsi singkat</x-input-label>
                    <textarea wire:model.defer="description" rows="3"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 focus:border-cgreen-500 focus:ring-cgreen-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100"
                        placeholder="Tambahkan konteks atau ringkasan sertifikat (opsional)"></textarea>
                    @error('description') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="block mb-1">File Sertifikat (PDF)</x-input-label>
                    <input type="file" wire:model="file" accept="application/pdf"
                        class="w-full text-sm text-neutral-700 file:mr-3 file:rounded-lg file:border-0 file:bg-cgreen-50 file:px-3 file:py-2 file:font-semibold file:text-cgreen-700 hover:file:bg-cgreen-100 dark:text-neutral-200 dark:file:bg-cgreen-900/30 dark:file:text-cgreen-300">
                    @error('file') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">PDF maksimal 10MB.</p>
                    @if ($currentFile)
                        <p class="mt-2 text-sm">
                            <a href="{{ asset($currentFile) }}" target="_blank"
                                class="text-cgreen-600 underline hover:text-cgreen-700 dark:text-cgreen-400">
                                Lihat file saat ini
                            </a>
                        </p>
                    @endif
                </div>
                <div>
                    <x-input-label class="block mb-1">Urutan Tampil</x-input-label>
                    <x-text-input type="number" min="0" wire:model.defer="position" class="w-full" placeholder="Contoh: 1" />
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Biarkan kosong untuk otomatis di akhir.</p>
                    @error('position') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-input-label class="block mb-1">Gambar Pratinjau (opsional, bisa crop)</x-input-label>
                    <div class="mt-1 flex items-center gap-3">
                        <div class="h-24 w-32 rounded-lg overflow-hidden border border-dashed border-neutral-300 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                            @if ($preview_image)
                                <img src="{{ $preview_image->temporaryUrl() }}" class="h-full w-full object-cover" alt="Preview" />
                            @elseif ($currentPreview)
                                <img src="{{ asset($currentPreview) }}" class="h-full w-full object-cover" alt="Preview" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-neutral-400">Belum ada gambar</div>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label class="inline-flex items-center gap-2 text-sm font-semibold text-cgreen-600 cursor-pointer">
                                <span class="rounded-lg bg-cgreen-50 px-3 py-2 hover:bg-cgreen-100 dark:bg-cgreen-900/30 dark:hover:bg-cgreen-900/50">Pilih Gambar</span>
                                <input type="file" class="hidden" accept="image/*" onchange="window.CertificateCropper.open(event)">
                            </label>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">PNG/JPG maks 4MB.</p>
                            @error('preview_image') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    <p class="font-semibold text-neutral-800 dark:text-neutral-100 mb-1">Tips</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Gunakan gambar resolusi jelas agar tampil rapi.</li>
                        <li>Crop bebas sesuai area yang ingin ditampilkan.</li>
                        <li>Jika kosong, akan memakai PDF untuk pratinjau.</li>
                    </ul>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-700 dark:bg-neutral-800">
                <p class="mb-3 text-sm font-semibold text-neutral-800 dark:text-neutral-100">Pratinjau gambar penuh</p>
                <div class="relative w-full min-h-40 max-h-[60vh] overflow-hidden rounded-lg bg-white dark:bg-neutral-900 border border-dashed border-neutral-200 dark:border-neutral-700">
                    @if ($preview_image)
                        <img src="{{ $preview_image->temporaryUrl() }}" class="absolute inset-0 h-full w-full object-contain" alt="Preview penuh">
                    @elseif ($currentPreview)
                        <img src="{{ asset($currentPreview) }}" class="absolute inset-0 h-full w-full object-contain" alt="Preview penuh">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-sm text-neutral-400">Belum ada gambar pratinjau</div>
                    @endif
                </div>
                @if ($currentPreview)
                    <div class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
                        <a href="{{ asset($currentPreview) }}" target="_blank" class="text-cgreen-600 underline hover:text-cgreen-700 dark:text-cgreen-400">Buka gambar asli di tab baru</a>
                    </div>
                @endif
            </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-border-button type="button" class="!w-auto" x-on:click="$dispatch('close')">Batal</x-border-button>
                <x-primary-button type="submit" class="!w-auto">
                    {{ $certificateId ? 'Simpan Perubahan' : 'Simpan Sertifikat' }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-modal name="delete-certificate" :show="false" maxWidth="md" align="center">
        <div class="p-6 space-y-3">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Hapus Sertifikat</h3>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Tindakan ini akan menghapus sertifikat dari daftar dan halaman utama.</p>
            <div class="flex justify-end gap-3">
                <x-border-button x-on:click="$dispatch('close')" class="!w-auto">Batal</x-border-button>
                <x-primary-button type="button" class="!w-auto" wire:click="delete">Hapus</x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="certificate-cropper" :show="false" maxWidth="3xl" align="center">
        <div class="p-4 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Crop Gambar Sertifikat</h3>
                <button type="button" class="text-neutral-400 hover:text-neutral-600" onclick="window.CertificateCropper.close()">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg overflow-hidden">
                <img id="certificateCropImage" class="max-h-[70vh] w-full object-contain" src="" alt="Gambar sertifikat">
            </div>
            <div class="flex justify-end gap-3">
                <x-border-button type="button" class="!w-auto" onclick="window.CertificateCropper.close()">Batal</x-border-button>
                <x-primary-button type="button" class="!w-auto" onclick="window.CertificateCropper.crop()">Crop & Simpan</x-primary-button>
            </div>
        </div>
    </x-modal>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script>
        window.CertificateCropper = {
            cropper: null,
            originalFile: null,
            open(event) {
                this.originalFile = event.target.files[0];
                if (!this.originalFile) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.getElementById('certificateCropImage');
                    img.src = e.target.result;

                    if (this.cropper) {
                        this.cropper.destroy();
                    }

                    img.onload = () => {
                        this.cropper = new Cropper(img, {
                            aspectRatio: NaN,
                            viewMode: 0,
                            dragMode: 'move',
                            autoCropArea: 1,
                            responsive: true,
                            background: false,
                        });
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'certificate-cropper' }));
                    };
                };
                reader.readAsDataURL(this.originalFile);
                event.target.value = '';
            },
            crop() {
                if (!this.cropper) return;
                const canvas = this.cropper.getCroppedCanvas({
                    imageSmoothingQuality: 'high',
                });
                canvas.toBlob((blob) => {
                    const file = new File([blob], `cert_preview_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    @this.upload('preview_image', file,
                        () => {
                            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'certificate-cropper' }));
                            this.cleanup();
                        },
                        (error) => {
                            console.error(error);
                            alert('Gagal mengunggah gambar, coba lagi.');
                        }
                    );
                }, 'image/jpeg', 0.9);
            },
            close() {
                this.cleanup();
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'certificate-cropper' }));
            },
            cleanup() {
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
                const img = document.getElementById('certificateCropImage');
                if (img) img.src = '';
            }
        };
    </script>
@endpush
