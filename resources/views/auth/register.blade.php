<x-guest-layout>
    <div class="space-y-4">
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-900">Cipta akaun baharu</h2>
            <p class="mt-1 text-sm text-gray-600">Daftar untuk mula tempah aktiviti di EduForest.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center rounded-xl bg-emerald-600 hover:bg-emerald-700">
                {{ __('Register') }}
            </x-primary-button>
        </form>

        <div class="text-center text-sm text-gray-600">
            Sudah ada akaun?
            <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Log masuk</a>
        </div>
    </div>
</x-guest-layout>
