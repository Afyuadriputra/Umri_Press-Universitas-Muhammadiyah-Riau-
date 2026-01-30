<x-surat-layout>
    <x-slot name="title">{{ $title }}</x-slot>

    @php
        $maxIncomingStatus = max($incomingStatus ?: [0]);
        $maxOutgoingStatus = max($outgoingStatus ?: [0]);
        $maxDispositionStatus = max($dispositionStatus ?: [0]);
        $maxIncomingMonthly = max($incomingMonthly ?: [0]);
        $maxOutgoingMonthly = max($outgoingMonthly ?: [0]);
    @endphp

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-semibold uppercase text-neutral-500">Surat Masuk</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $summary['incoming'] }}</p>
                <p class="mt-1 text-xs text-neutral-500">Total data</p>
            </div>
            <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-semibold uppercase text-neutral-500">Surat Keluar</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $summary['outgoing'] }}</p>
                <p class="mt-1 text-xs text-neutral-500">Total data</p>
            </div>
            <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-semibold uppercase text-neutral-500">Disposisi</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $summary['dispositions'] }}</p>
                <p class="mt-1 text-xs text-neutral-500">Total disposisi</p>
            </div>
            <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-semibold uppercase text-neutral-500">Template Surat</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $summary['templates'] }}</p>
                <p class="mt-1 text-xs text-neutral-500">Template aktif</p>
            </div>
            <div class="rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-xs font-semibold uppercase text-neutral-500">Notifikasi</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $summary['unreadNotifications'] }}</p>
                <p class="mt-1 text-xs text-neutral-500">Belum dibaca</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Flow Surat Masuk</h2>
                        <p class="text-xs text-neutral-500">Ringkasan status surat masuk.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm">
                    @foreach ($incomingStatus as $status => $count)
                        <div class="rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-center dark:border-neutral-700 dark:bg-neutral-800">
                            <x-surat-status-badge :status="$status" context="incoming" class="mx-auto" />
                            <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $count }}</p>
                        </div>
                        @if (! $loop->last)
                            <span class="text-neutral-300">→</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Flow Surat Keluar</h2>
                        <p class="text-xs text-neutral-500">Ringkasan status surat keluar.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-sm">
                    @foreach ($outgoingStatus as $status => $count)
                        <div class="rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-center dark:border-neutral-700 dark:bg-neutral-800">
                            <x-surat-status-badge :status="$status" context="outgoing" class="mx-auto" />
                            <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $count }}</p>
                        </div>
                        @if (! $loop->last)
                            <span class="text-neutral-300">→</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Statistik Surat Masuk</h2>
                <p class="text-xs text-neutral-500">Distribusi status surat masuk.</p>
                <div class="mt-4 space-y-3">
                    @foreach ($incomingStatus as $status => $count)
                        @php
                            $percent = $maxIncomingStatus ? round(($count / $maxIncomingStatus) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs text-neutral-500">
                                <x-surat-status-badge :status="$status" context="incoming" />
                                <span>{{ $count }}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-neutral-100 dark:bg-neutral-800">
                                <div class="h-2 rounded-full bg-cgreen-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Statistik Surat Keluar</h2>
                <p class="text-xs text-neutral-500">Distribusi status surat keluar.</p>
                <div class="mt-4 space-y-3">
                    @foreach ($outgoingStatus as $status => $count)
                        @php
                            $percent = $maxOutgoingStatus ? round(($count / $maxOutgoingStatus) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs text-neutral-500">
                                <x-surat-status-badge :status="$status" context="outgoing" />
                                <span>{{ $count }}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-neutral-100 dark:bg-neutral-800">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 xl:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Tren Surat 6 Bulan Terakhir</h2>
                        <p class="text-xs text-neutral-500">Perbandingan surat masuk vs surat keluar.</p>
                    </div>
                </div>
                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase text-neutral-500">Surat Masuk</p>
                        <div class="mt-3 flex items-end gap-2">
                            @foreach ($incomingMonthly as $month => $count)
                                @php
                                    $height = $maxIncomingMonthly ? max(10, round(($count / $maxIncomingMonthly) * 120)) : 10;
                                @endphp
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-6 rounded-full bg-cgreen-500/80" style="height: {{ $height }}px"></div>
                                    <span class="text-[10px] text-neutral-400">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-neutral-500">Surat Keluar</p>
                        <div class="mt-3 flex items-end gap-2">
                            @foreach ($outgoingMonthly as $month => $count)
                                @php
                                    $height = $maxOutgoingMonthly ? max(10, round(($count / $maxOutgoingMonthly) * 120)) : 10;
                                @endphp
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-6 rounded-full bg-indigo-500/80" style="height: {{ $height }}px"></div>
                                    <span class="text-[10px] text-neutral-400">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Status Disposisi</h2>
                <p class="text-xs text-neutral-500">Aktivitas disposisi saat ini.</p>
                <div class="mt-4 space-y-3">
                    @foreach ($dispositionStatus as $status => $count)
                        @php
                            $percent = $maxDispositionStatus ? round(($count / $maxDispositionStatus) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs text-neutral-500">
                                <x-surat-status-badge :status="$status" context="disposisi" />
                                <span>{{ $count }}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-neutral-100 dark:bg-neutral-800">
                                <div class="h-2 rounded-full bg-amber-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Surat Masuk Terbaru</h2>
                <p class="text-xs text-neutral-500">5 surat masuk terakhir.</p>
                <div class="mt-4 space-y-3">
                    @forelse ($recentIncoming as $letter)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-neutral-100 px-4 py-3 text-sm dark:border-neutral-800">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $letter->subject }}</p>
                                <p class="text-xs text-neutral-500">{{ $letter->sender }}</p>
                            </div>
                            <div class="text-right">
                                <x-surat-status-badge :status="$letter->status" context="incoming" />
                                <div class="mt-1 text-xs text-neutral-400">{{ optional($letter->received_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">Belum ada surat masuk.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Surat Keluar Terbaru</h2>
                <p class="text-xs text-neutral-500">5 surat keluar terakhir.</p>
                <div class="mt-4 space-y-3">
                    @forelse ($recentOutgoing as $letter)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-neutral-100 px-4 py-3 text-sm dark:border-neutral-800">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $letter->subject }}</p>
                                <p class="text-xs text-neutral-500">{{ $letter->recipient }}</p>
                            </div>
                            <div class="text-right">
                                <x-surat-status-badge :status="$letter->status" context="outgoing" />
                                <div class="mt-1 text-xs text-neutral-400">{{ optional($letter->sent_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">Belum ada surat keluar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-surat-layout>



