<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form wire:submit="confirmPassword">
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input wire:model="password"
                              id="password"
                              class="block mt-1 w-full pr-24"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <button type="button" data-toggle-password data-target="password"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-500 hover:text-neutral-700">
                    <span data-label="show" class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z" />
                            <circle cx="12" cy="12" r="3.25" />
                        </svg>
                    </span>
                    <span data-label="hide" class="hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 10.5a2.5 2.5 0 0 0 3.5 3.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.23 6.23C4.14 7.64 2.25 12 2.25 12s3.75 7.5 9.75 7.5c2.01 0 3.8-.61 5.31-1.49" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.7 4.68A9.23 9.23 0 0 1 12 4.5c6 0 9.75 7.5 9.75 7.5a17.62 17.62 0 0 1-2.02 3.18" />
                        </svg>
                    </span>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</div>
