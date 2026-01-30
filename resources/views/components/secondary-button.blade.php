<button {{ $attributes->merge(['type' => 'button', 'class' => 'block w-full text-center bg-neutral-500 text-white px-6 py-2.5 rounded-full text-sm font-semibold uppercase hover:bg-neutral-600 transition-all duration-300 hover:shadow-lg hover:shadow-neutral-500/30 active:scale-95 tracking-wide cursor-pointer dark:bg-neutral-600 dark:hover:bg-neutral-700']) }}>
    {{ $slot }}
</button>
