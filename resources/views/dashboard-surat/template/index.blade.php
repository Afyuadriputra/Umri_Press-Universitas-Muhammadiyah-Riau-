<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Template Surat</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Kelola template surat keluar.</p>
            </div>
            <a href="{{ route('dashboard-surat.template.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-cgreen-600 px-4 py-2 text-sm font-semibold text-white hover:bg-cgreen-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Template
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($templates as $template)
                            <tr class="text-neutral-700 dark:text-neutral-200">
                                <td class="px-4 py-3">{{ $template->name }}</td>
                                <td class="px-4 py-3">{{ $template->type_code ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $template->is_active ? 'bg-cgreen-100 text-cgreen-800 dark:bg-cgreen-900/30 dark:text-cgreen-300' : 'bg-neutral-100 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300' }}">
                                        {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('dashboard-surat.template.edit', $template) }}"
                                            class="rounded-lg border border-neutral-200 px-2.5 py-1.5 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('dashboard-surat.template.destroy', $template) }}" onsubmit="return confirm('Hapus template ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-300 dark:hover:bg-red-900/30">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                    Belum ada template.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4">
                {{ $templates->links() }}
            </div>
        </div>
    </div>
</x-surat-layout>
