@props([
    'status' => '',
    'context' => 'default',
])

@php
    $statusKey = strtolower((string) $status);
    $contextKey = strtolower((string) $context);

    $palettes = [
        'incoming' => [
            'baru' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            'diproses' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
            'selesai' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
            'arsip' => 'bg-neutral-200 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200',
        ],
        'outgoing' => [
            'draft' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
            'sent' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            'archived' => 'bg-neutral-200 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200',
        ],
        'disposisi' => [
            'baru' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
            'diproses' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
            'selesai' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
        ],
    ];

    $contextPalette = $palettes[$contextKey] ?? [];
    $class = $contextPalette[$statusKey] ?? 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200';
@endphp

<span {{ $attributes->merge(['class' => "rounded-full px-2.5 py-1 text-xs font-semibold {$class}"]) }}>
    {{ strtoupper($statusKey) }}
</span>
