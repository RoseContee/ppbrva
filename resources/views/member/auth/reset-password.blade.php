<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Enter the code received to your email address.') }}
    </div>

    <form method="POST" action="{{ route('member.password.reset') }}">
        @csrf

        <!-- Reset Code -->
        <div>
            <x-input-label for="code" :value="__('Code')" />
            <x-text-input type="text" name="code" id="code" class="block mt-1 w-full"
                          :value="old('code')" autofocus autocomplete="off"
                          required />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input type="email" name="email" id="email" class="block mt-1 w-full"
                          :value="old('email')" autocomplete="username"
                          required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input type="password" name="password" id="password" class="block mt-1 w-full"
                          autocomplete="new-password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input type="password" id="password_confirmation" name="password_confirmation" class="block mt-1 w-full"
                          autocomplete="new-password" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
