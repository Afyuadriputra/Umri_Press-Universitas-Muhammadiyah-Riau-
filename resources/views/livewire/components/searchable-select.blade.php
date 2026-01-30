<div class="relative" x-data="{ open: @entangle('showDropdown') }" @click.outside="$wire.closeDropdown()">
    <div class="relative">
        <!-- Selected Item Display -->
        <div @click="$wire.toggleDropdown()"
            class="w-full cursor-pointer bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg flex items-center justify-between p-2.5 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
            @if ($multiple)
                <div class="flex flex-wrap gap-1">
                    @if (count($selected))
                        @foreach ($selected as $idx => $val)
                            <span
                                class="inline-flex items-center px-2 py-1 bg-cgreen-100 text-cgreen-800 rounded text-xs">
                                {{ $selectedText[$idx] ?? '' }}
                                <button type="button" @click.stop="$wire.clearSelection('{{ $val }}')"
                                    class="ml-1 text-cgreen-600 hover:text-red-500">
                                    &times;
                                </button>
                                <input type="hidden" name="{{ $name }}[]" value="{{ $val }}">
                            </span>
                        @endforeach
                    @else
                        <span class="block truncate text-neutral-500 dark:text-neutral-400">{{ $placeholder }}</span>
                    @endif
                </div>
            @else
                @if ($selected)
                    <span class="block truncate text-neutral-900 dark:text-neutral-100">{{ $selectedText }}</span>
                    @if (!$disabled)
                        <button type="button" @click.stop="$wire.clearSelection()"
                            class="text-neutral-400 hover:text-neutral-500 dark:hover:text-neutral-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                @else
                    <span class="block truncate text-neutral-500 dark:text-neutral-400">{{ $placeholder }}</span>
                    <span class="text-neutral-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                @endif
            @endif
        </div>

        <!-- Dropdown -->
        <div x-show="open" x-cloak
            class="absolute z-50 w-full mt-1 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-lg">
            <!-- Search Input -->
            <div class="p-2 border-b border-neutral-200 dark:border-neutral-700">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full border-neutral-300 dark:border-neutral-600 focus:border-cgreen-500 focus:ring-cgreen-500 rounded-md dark:bg-neutral-800 dark:text-neutral-200"
                    placeholder="Search...">
            </div>

            <!-- Options List -->
            <ul class="max-h-60 overflow-y-auto py-2">
                @forelse($this->filteredItems as $value => $text)
                    <li wire:key="option-{{ $value }}"
                        class="px-3 py-2 cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 {{ ($multiple ? in_array($value, $selected) : $selected === $value) ? 'bg-neutral-100 dark:bg-neutral-700' : '' }}"
                        wire:click="selectItem('{{ $value }}', '{{ $text }}')">
                        <span
                            class="block truncate {{ ($multiple ? in_array($value, $selected) : $selected === $value) ? 'font-medium' : 'font-normal' }}">
                            {{ $text }}
                        </span>
                    </li>
                @empty
                    <li class="px-3 py-2 text-neutral-500 dark:text-neutral-400">
                        No results found.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Hidden Input for Form Submission (single mode) -->
    @if (!$multiple)
        <input type="hidden" name="{{ $name }}" value="{{ $selected }}">
    @endif
</div>
