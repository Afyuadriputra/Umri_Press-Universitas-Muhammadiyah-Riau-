@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500 rounded-lg text-neutral-800 dark:text-neutral-200 dark:bg-neutral-800 dark:border-neutral-600 dark:focus:border-cgreen-500 dark:focus:ring-cgreen-500']) }}>
    {{ $slot }}
</select>