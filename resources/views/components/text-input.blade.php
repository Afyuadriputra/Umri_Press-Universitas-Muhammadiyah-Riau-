@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-300 focus:border-cgreen-500 focus:ring-cgreen-500 rounded-lg placeholder:text-neutral-400 placeholder:text-sm dark:text-neutral-200 dark:bg-neutral-800 dark:border-neutral-600 dark:placeholder:text-neutral-500']) }}>
