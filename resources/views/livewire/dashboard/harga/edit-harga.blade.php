@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endpush

@push('scripts')
    <script>
        window.EditorManager = {
            editors: {},

            init() {
                if (typeof Quill === 'undefined') {
                    setTimeout(() => this.init(), 100);
                    return;
                }

                if (!document.getElementById('konten')) {
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
                            ['link', 'image'],
                            ['clean']
                        ]
                    },
                };

                if (!this.editors.konten) {
                    this.initializeEditor('konten', quillConfig, component);
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

                const initialContent = component.get(id);
                if (initialContent) {
                    editor.root.innerHTML = initialContent;
                }

                editor.on('text-change', () => {
                    const content = editor.root.innerHTML.trim();
                    component.dispatch('set-konten', {
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

<div class="max-w-4xl mx-auto p-6">
    @include('components.alert')

    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Edit Paket</h2>
            <a href="{{ route('semuaPaket') }}" wire:navigate>
                <x-border-button class="!inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Kembali
                </x-border-button>
            </a>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <x-input-label>Nama Paket <span class="text-cgreen-500">*</span></x-input-label>
                <x-text-input wire:model="nama" class="w-full mt-1" placeholder="Contoh: Paket Basic" />
                @error('nama')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input-label class="block mb-2">Deskripsi</x-input-label>
                <div wire:ignore>
                    <div id="konten" class="h-96 bg-white dark:bg-neutral-800">{!! $deskripsi !!}</div>
                </div>
                @error('konten')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="active"
                        class="rounded border-neutral-300 text-cgreen-600 shadow-sm focus:border-cgreen-300 focus:ring focus:ring-cgreen-200 focus:ring-opacity-50">
                    <span class="ml-2">Aktifkan Paket</span>
                </label>
            </div>

            <div class="flex justify-end">
                <x-primary-button type="submit">
                    Simpan Perubahan
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
