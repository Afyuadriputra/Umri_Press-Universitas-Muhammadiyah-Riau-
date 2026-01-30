<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block w-full text-center bg-cgreen-500 text-white px-6 py-2.5 rounded-full text-sm font-semibold uppercase hover:bg-cgreen-600 transition-all duration-300 hover:shadow-lg hover:shadow-cgreen-500/30 active:scale-95 tracking-wide cursor-pointer']) }}>
    {{ $slot }}
</button>
