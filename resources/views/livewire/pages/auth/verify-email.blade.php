<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="min-h-screen flex items-center justify-center py-8 px-2 bg-gradient-to-br from-indigo-100 to-blue-100">
        <div class="w-full max-w-md glass rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Verify your email address</h2>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif
            <div class="mt-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <x-primary-button wire:click="sendVerification" class="w-full md:w-auto justify-center text-base py-3">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
                <a href="{{ route('logout') }}" class="w-full md:w-auto justify-center px-6 py-3 rounded-lg font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50 transition text-base text-center block">
                    {{ __('Log Out') }}
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="w-full text-center py-4 text-gray-500 text-sm">
    Made by <a href="https://github.com/raoazwar" target="_blank" class="text-indigo-600 hover:underline">rao azwar</a>
</footer>
