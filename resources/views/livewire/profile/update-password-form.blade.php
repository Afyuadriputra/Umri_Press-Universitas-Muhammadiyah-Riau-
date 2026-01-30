<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full pr-24" autocomplete="current-password" />
                <button type="button" data-toggle-password data-target="update_password_current_password"
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
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative">
                <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full pr-24" autocomplete="new-password" />
                <button type="button" data-toggle-password data-target="update_password_password"
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

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full pr-24" autocomplete="new-password" />
                <button type="button" data-toggle-password data-target="update_password_password_confirmation"
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
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
