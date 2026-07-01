<x-guest-layout>
    <div class="space-y-4">
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-900">Selamat datang semula</h2>
            <p class="mt-1 text-sm text-gray-600">Log masuk ke akaun EduForest anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-emerald-600 hover:text-emerald-700" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-xl bg-emerald-600 hover:bg-emerald-700">
                {{ __('Log in') }}
            </x-primary-button>
        </form>

        <div class="text-center text-sm text-gray-600">
            Belum ada akaun?
            <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Daftar sekarang</a>
        </div>
    </div>
</x-guest-layout>
