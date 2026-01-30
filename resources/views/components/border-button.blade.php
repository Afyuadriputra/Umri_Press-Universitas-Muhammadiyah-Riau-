<button {{ $attributes->merge(['type' => 'button', 'class' => 'block w-full text-center border border-neutral-300 text-neutral-800 px-4 py-2 rounded-full text-sm font-semibold hover:border-neutral-400 transition-all duration-300 active:scale-95 tracking-wide cursor-pointer dark:text-neutral-200 dark:border-neutral-700']) }}>
	{{ $slot }}
</button>
