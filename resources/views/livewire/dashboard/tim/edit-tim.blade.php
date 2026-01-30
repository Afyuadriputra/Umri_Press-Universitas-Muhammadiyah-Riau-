<div class="max-w-4xl mx-auto p-6">
    @include('components.alert')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
        <script src="{{ asset('js/cropper.min.js') }}"></script>
    @endpush

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-neutral-900 dark:text-neutral-100">Edit Anggota Tim</h2>

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Foto Upload -->
            <div>
                <x-input-label class="block mb-2">
                    Foto Profil (Ukuran yang disarankan: 400x400px)
                </x-input-label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 dark:border-neutral-700 border-dashed rounded-lg relative">
                    <div class="space-y-1 text-center">
                        @if ($foto)
                            <img src="{{ $foto->temporaryUrl() }}" alt="Preview"
                                class="mx-auto h-32 w-32 object-cover rounded-full mb-4" id="previewImage">
                        @elseif ($oldFoto)
                            <img src="{{ asset($oldFoto) }}" alt="Current Photo"
                                class="mx-auto h-32 w-32 object-cover rounded-full mb-4" id="previewImage">
                        @else
                            <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <div class="flex justify-center text-sm text-neutral-600 dark:text-neutral-400">
                            <label
                                class="relative cursor-pointer rounded-md font-medium text-cgreen-600 hover:text-cgreen-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-cgreen-500">
                                <span>Upload foto</span>
                                <input type="file" class="sr-only" accept="image/*" id="foto"
                                    onchange="openCropper(event)">
                            </label>
                        </div>
                        <p class="text-xs text-neutral-500">PNG, JPG up to 2MB</p>
                    </div>
                </div>
                @error('foto')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <x-input-label class="block mb-2">Nama</x-input-label>
                <x-text-input type="text" wire:model="nama" class="w-full" placeholder="Nama lengkap" />
                @error('nama')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <x-input-label class="block mb-2">Jabatan</x-input-label>
                <x-text-input type="text" wire:model="jabatan" class="w-full" placeholder="Jabatan/Posisi" />
                @error('jabatan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <x-input-label class="block mb-2">Deskripsi</x-input-label>
                <textarea wire:model="deskripsi"
                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500"
                    rows="4" placeholder="Deskripsi singkat tentang anggota tim"></textarea>
                @error('deskripsi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Social Media Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label class="block mb-2">Instagram URL</x-input-label>
                    <x-text-input type="url" wire:model="instagram" class="w-full" placeholder="https://instagram.com/username" />
                    @error('instagram')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">Facebook URL</x-input-label>
                    <x-text-input type="url" wire:model="facebook" class="w-full" placeholder="https://facebook.com/username" />
                    @error('facebook')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">Twitter URL</x-input-label>
                    <x-text-input type="url" wire:model="twitter" class="w-full" placeholder="https://twitter.com/username" />
                    @error('twitter')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input-label class="block mb-2">LinkedIn URL</x-input-label>
                    <x-text-input type="url" wire:model="linkedin" class="w-full" placeholder="https://linkedin.com/in/username" />
                    @error('linkedin')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-primary-button type="submit">
                    Simpan Perubahan
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Cropper Modal -->
    <x-modal name="cropperModal" :show="false" maxWidth="xl" align="center">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">
                    {{ __('Crop Image') }}
                </h2>
                <button type="button" class="text-neutral-400 hover:text-neutral-500" onclick="closeCropModal()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-4 bg-neutral-50 dark:bg-neutral-900 rounded-lg">
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
                                    aspectRatio: 1,
                                    viewMode: 1,
                                    dragMode: 'move',
                                    autoCropArea: 1,
                                    restore: false,
                                    guides: true,
                                    center: true,
                                    highlight: true,
                                    cropBoxMovable: true,
                                    cropBoxResizable: true,
                                    toggleDragModeOnDblclick: false,
                                    minContainerWidth: 400,
                                    minContainerHeight: 400
                                });
                                @this.dispatch('open-modal', 'cropperModal');
                            };
                        };
                        reader.readAsDataURL(this.originalFile);
                        event.target.value = '';
                    };

                    window.cropImage = () => {
                        if (!this.cropper) return;

                        const canvas = this.cropper.getCroppedCanvas({
                            width: 400,
                            height: 400,
                            imageSmoothingEnabled: true,
                            imageSmoothingQuality: 'high',
                        });

                        canvas.toBlob((blob) => {
                            const file = new File([blob], `${this.originalFile.name.split('.')[0]}_400x400.jpg`, {
                                type: 'image/jpeg'
                            });

                            @this.upload('foto', file,
                                (uploadedFilename) => {
                                    const previewImage = document.getElementById('previewImage');
                                    if (previewImage) {
                                        previewImage.src = URL.createObjectURL(file);
                                    }

                                    window.dispatchEvent(new CustomEvent('close-modal', {
                                        detail: 'cropperModal'
                                    }));

                                    this.cleanup();
                                },
                                (error) => {
                                    console.error('Upload failed:', error);
                                    alert('Failed to upload image. Please try again.');
                                }
                            );
                        }, 'image/jpeg', 0.9);
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
    @endpush
</div>