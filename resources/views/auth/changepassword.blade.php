<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('updatepassword') }}">
            @csrf

            <!-- Password Reset Token -->

            <!-- Email Address -->
          

            <!-- Password -->
            <div class="mt-4">
                <x-input id="otpcode" class="block mt-1 w-full" type="hidden" name="otpcode" required value="{{$verificationdata->otpcode}}" />
                <x-input id="user_id" class="block mt-1 w-full" type="hidden" name="user_id" required value="{{$verificationdata->user_id}}" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
