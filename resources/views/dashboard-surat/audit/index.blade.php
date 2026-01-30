<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    <div class="space-y-6">
        @include('components.alert')

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Audit Log Surat</h1>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Riwayat aktivitas pada modul surat.</p>
        </div>

        <form method="GET" class="grid gap-3 rounded-2xl border border-neutral-200 bg-white p-4 text-sm shadow-sm dark:border-neutral-700 dark:bg-neutral-900 md:grid-cols-6">
            <div class="md:col-span-3">
                <x-text-input name="search" value="{{ request('search') }}" class="w-full" placeholder="Cari aksi/entitas" />
            </div>
            <div class="md:col-span-2">
                <x-select name="user_id" class="w-full">
                    <option value="">Semua pengguna</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string) request('user_id') === (string) $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="flex items-center justify-end gap-2 md:col-span-1">
                <a href="{{ route('dashboard-surat.audit.index') }}" class="rounded-lg border border-neutral-200 px-3 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">Reset</a>
                <button type="submit" class="rounded-lg bg-cgreen-600 px-3 py-2 text-xs font-semibold text-white hover:bg-cgreen-700">Filter</button>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-neutral-50 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-300">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                            <th class="px-4 py-3 text-left font-semibold">User</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            <th class="px-4 py-3 text-left font-semibold">Entitas</th>
                            <th class="px-4 py-3 text-left font-semibold">Meta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($logs as $log)
                            <tr class="text-neutral-700 dark:text-neutral-200">
                                <td class="px-4 py-3">{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $log->user?->name ?? '-' }}</div>
                                    <div class="text-xs text-neutral-500">{{ $log->user?->email ?? '' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $action = (string) $log->action;
                                        $actionClass = 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200';
                                        if (str_contains($action, 'create')) {
                                            $actionClass = 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300';
                                        } elseif (str_contains($action, 'update')) {
                                            $actionClass = 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300';
                                        } elseif (str_contains($action, 'delete')) {
                                            $actionClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                                        } elseif (str_contains($action, 'archive')) {
                                            $actionClass = 'bg-neutral-200 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200';
                                        }
                                    @endphp
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $actionClass }}">
                                        {{ strtoupper($action) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-xs text-neutral-500">{{ class_basename($log->entity_type) }}</div>
                                    <div>#{{ $log->entity_id ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-xs text-neutral-500">
                                    {{ $log->meta ? json_encode($log->meta) : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                    Belum ada audit log.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-surat-layout>
