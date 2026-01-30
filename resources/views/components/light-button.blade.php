<button {{ $attributes->merge(['type' => 'button', 'class' => 'block text-center bg-white text-cgreen-500 px-6 py-2.5 rounded-full text-sm font-semibold uppercase transition-all duration-300 hover:shadow-lg hover:shadow-white/30 active:scale-95 tracking-wide cursor-pointer']) }}>
	{{ $slot }}
</button>
