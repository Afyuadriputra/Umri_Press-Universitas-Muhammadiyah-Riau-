<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('author.index', absolute: false), navigate: false);
    }
}; ?>

<div>
    @if (session('error'))
        <div class="fixed inset-x-0 top-6 z-50 flex justify-center px-4" x-data="{ show: true }" x-show="show">
            <div class="flex w-full max-w-md items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 shadow-lg dark:border-red-900/40 dark:bg-red-900/30 dark:text-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.485 2.495a1.5 1.5 0 0 1 2.53 0l6.347 11.003A1.5 1.5 0 0 1 16.05 15.75H3.95a1.5 1.5 0 0 1-1.312-2.252L8.485 2.495ZM11 13a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-1-8a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1Z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1 text-sm font-medium">
                    {{ session('error') }}
                </div>
                <button type="button" class="text-red-500 hover:text-red-700" @click="show = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="mb-6 text-center">
        <a href="{{ route('home') }}" class="inline-flex justify-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}"
                class="h-12 dark:hidden">
            <img src="{{ asset('assets/img/logo-white.png') }}" alt="{{ config('app.name') }}"
                class="h-12 hidden dark:block">
        </a>
        <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Login Penulis</h1>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Masuk untuk melihat dashboard royalti.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full pr-24"
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

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-sm border-gray-300 text-cgreen-600 shadow-xs focus:ring-cgreen-500 duration-200" name="remember">
                <span class="ms-2 text-sm text-gray-600 select-none">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-neutral-500 text-center hover:underline block" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
