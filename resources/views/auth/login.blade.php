<x-guest-layout>
<<<<<<< HEAD
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4" style="background-color: #f3f4f6;">
        <div class="w-full max-w-md bg-white p-8 border border-gray-100 text-center" style="background-color: white; border-radius: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 28rem; margin: auto; padding: 2rem;">
            
            <div class="flex justify-center mb-2" style="display: flex; justify-content: center; margin-bottom: 0.5rem;">
                <img src="https://your-project-id.supabase.co/storage/v1/object/public/your-bucket/logo-eduforest.png" 
                    alt="Edu-Forest Logo" style="height: 5rem; width: auto; object-fit: contain;">
            </div>

            <div class="mb-6" style="margin-bottom: 1.5rem;">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight" style="font-size: 1.5rem; font-weight: 700; color: #111827;">Welcome Back!</h2>
                <p class="text-sm text-gray-500 mt-1" style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">Log in to continue your nature adventure.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left" style="text-align: left;" autocomplete="off">
                @csrf

                <input type="text" name="fake_username_remembered" style="display:none" autocomplete="disabled">
                <input type="password" name="fake_password_remembered" style="display:none" autocomplete="disabled">

                <div style="margin-bottom: 1rem;">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Email Address</label>
                    <input id="email" type="email" name="email" required autofocus placeholder="Enter your email address" 
                        autocomplete="new-password"
                        class="block w-full px-4 py-3 rounded-2xl bg-gray-50 border border-gray-200 text-sm" 
                        style="display: block; width: 100%; padding: 0.75rem 1rem; border-radius: 1rem; background-color: #f9fafb; border: 1px solid #e5e7eb; font-size: 0.875rem; box-sizing: border-box;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Password</label>
                    <input id="password" type="password" name="password" required placeholder="Enter your password" 
                        autocomplete="new-password"
                        class="block w-full px-4 py-3 rounded-2xl bg-gray-50 border border-gray-200 text-sm" 
                        style="display: block; width: 100%; padding: 0.75rem 1rem; border-radius: 1rem; background-color: #f9fafb; border: 1px solid #e5e7eb; font-size: 0.875rem; box-sizing: border-box;" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="flex justify-between items-center pt-1" style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.25rem; margin-bottom: 1.5rem;">
                    <label class="flex items-center" style="display: flex; align-items: center;">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-800 focus:ring-emerald-800">
                        <span class="ms-2 text-xs text-gray-600" style="margin-left: 0.5rem; font-size: 0.75rem; color: #4b5563;">Remember Me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold hover:underline" href="{{ route('password.request') }}" style="font-size: 0.75rem; font-weight: 600; color: #f87171; text-decoration: none;">
                            Forgot Password
                        </a>
                    @endif </div>

                <div class="pt-2" style="padding-top: 0.5rem;">
                    <button type="submit" 
                            style="display: block; width: 100%; background-color: #2d5a3b; color: white; font-weight: 700; padding: 0.875rem 1rem; border-radius: 1rem; border: none; font-size: 0.875rem; cursor: pointer; text-align: center; box-shadow: 0 4px 6px -1px rgba(45, 90, 59, 0.3);">
                        Log In
                    </button>
                </div>
            </form>

            <div class="text-center mt-6 pt-4 border-t border-gray-100" style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                <p class="text-sm text-gray-600" style="font-size: 0.875rem; color: #4b5563;">
                    Don't have an account? 
                    <a href="{{ route('register') }}" style="font-weight: 700; color: #2d5a3b; text-decoration: none;">
                        Sign Up Now
                    </a>
                </p>
            </div>

        </div>
    </div>
</x-guest-layout>
=======
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
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
