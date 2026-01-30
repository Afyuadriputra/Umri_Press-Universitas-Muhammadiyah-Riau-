<div class="p-6">
    @include('components.alert')

    <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 mb-6">Pengaturan Website</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach ($settings as $group => $groupSettings)
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4 capitalize text-neutral-900 dark:text-neutral-100">
                    {{ $group }}
                </h3>
                @if ($group === 'pembayaran')
                    <div class="mb-4 rounded-lg border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-300">
                        Atur Nomor WhatsApp dan Email admin khusus untuk menerima bukti pembayaran.
                    </div>
                @endif

                <div class="space-y-6">
                    @foreach ($groupSettings as $setting)
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    {{ $setting['display_name'] }}
                                </label>
                                @if ($setting['keterangan'])
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $setting['keterangan'] }}
                                    </span>
                                @endif
                            </div>

                            @switch($setting['type'])
                                @case('image')
                                    <div>
                                        @if ($setting['value'])
                                            <div
                                                class="{{ $setting['key'] === 'logo-white' ? 'bg-neutral-950 p-4' : '' }} rounded-lg mb-2">
                                                <img src="{{ asset($setting['value']) }}" alt="{{ $setting['display_name'] }}"
                                                    class="h-20 object-contain {{ $setting['key'] === 'logo-white' ? 'mx-auto' : '' }}">
                                            </div>
                                        @endif

                                        <input type="file" wire:model="images.{{ $setting['key'] }}"
                                            class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                file:mr-4 file:py-2 file:px-4 file:rounded-lg
                file:border-0 file:text-sm file:font-medium
                file:bg-cgreen-50 file:text-cgreen-700
                hover:file:bg-cgreen-100
                dark:file:bg-cgreen-900/20 dark:file:text-cgreen-400"
                                            accept="image/*">
                                    </div>
                                @break

                                @case('pdf')
                                    <div>
                                        @if ($setting['value'])
                                            <div class="mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-8 text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                                        PDF Saat Ini
                                                    </p>
                                                    <a href="{{ asset($setting['value']) }}" target="_blank"
                                                        class="text-xs text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-400 dark:hover:text-cgreen-300">
                                                        Lihat PDF
                                                    </a>
                                                </div>
                                                <button type="button" wire:click="deletePdf('{{ $setting['key'] }}')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif

                                        <input type="file" wire:model="files.{{ $setting['key'] }}"
                                            class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                file:mr-4 file:py-2 file:px-4 file:rounded-lg
                file:border-0 file:text-sm file:font-medium
                file:bg-cgreen-50 file:text-cgreen-700
                hover:file:bg-cgreen-100
                dark:file:bg-cgreen-900/20 dark:file:text-cgreen-400"
                                            accept="application/pdf">

                                        <div wire:loading wire:target="files.{{ $setting['key'] }}"
                                            class="mt-2 text-sm text-neutral-500">
                                            Mengupload file...
                                        </div>
                                    </div>
                                @break

                                @case('textarea')
                                    <textarea wire:model.blur="settings.{{ $group }}.{{ $loop->index }}.value"
                                        wire:change="updateSetting('{{ $setting['key'] }}', $event.target.value)"
                                        class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500"
                                        rows="3">{{ $setting['value'] }}</textarea>
                                @break

                                @case('docx')
                                    <div>
                                        @if ($setting['value'])
                                            <div class="mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-8 text-blue-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                                        Template Saat Ini
                                                    </p>
                                                    <a href="{{ asset($setting['value']) }}" download
                                                        class="text-xs text-cgreen-600 hover:text-cgreen-700 dark:text-cgreen-400 dark:hover:text-cgreen-300">
                                                        Unduh Template
                                                    </a>
                                                </div>
                                                <button type="button" wire:click="deleteDoc('{{ $setting['key'] }}')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif

                                        <input type="file" wire:model="files.{{ $setting['key'] }}"
                                            class="block w-full text-sm text-neutral-500 dark:text-neutral-400
            file:mr-4 file:py-2 file:px-4 file:rounded-lg
            file:border-0 file:text-sm file:font-medium
            file:bg-cgreen-50 file:text-cgreen-700
            hover:file:bg-cgreen-100
            dark:file:bg-cgreen-900/20 dark:file:text-cgreen-400"
                                            accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document">

                                        <div wire:loading wire:target="files.{{ $setting['key'] }}"
                                            class="mt-2 text-sm text-neutral-500">
                                            Mengupload template...
                                        </div>
                                    </div>
                                @break

                                @default
                                    <input type="{{ $setting['type'] }}"
                                        wire:model.blur="settings.{{ $group }}.{{ $loop->index }}.value"
                                        wire:change="updateSetting('{{ $setting['key'] }}', $event.target.value)"
                                        class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500">
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
