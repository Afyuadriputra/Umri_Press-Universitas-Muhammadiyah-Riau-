<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="delete_account_password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative w-3/4">
                    <x-text-input
                        wire:model="password"
                        id="delete_account_password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full pr-24"
                        placeholder="{{ __('Password') }}"
                    />
                    <button type="button" data-toggle-password data-target="delete_account_password"
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

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
