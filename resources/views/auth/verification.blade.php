<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
jjjj
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        @if(auth('web')->check())
        <form method="POST" action="{{ route('Sure_verifycode') }}">
       
        @else
        <form method="POST" action="{{ route('Sure_verifycode') }}">
        @endif
            @csrf

            <!-- Name -->

            <div>

                <x-label for="name" :value="__('Enter Otp-Code')" />

                <x-input id="otpcode" class="block mt-1 w-full" type="text" name="otpcode" :value="old('otpcode')" required autofocus />
            </div>

           

           

           
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
