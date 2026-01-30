<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full pr-24"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
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

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full pr-24"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <button type="button" data-toggle-password data-target="password_confirmation"
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

        <div class="mt-4">

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>

            <div class="mt-3">
                <p class="text-center text-neutral-500 text-sm">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-red-600 hover:underline" wire:navigate>Masuk sekarang</a></p>
            </div>
        </div>
    </form>
</div>
