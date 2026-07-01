<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, email address, and profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_image" :value="__('Profile Picture')" />
            <input id="profile_image" name="profile_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
            <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maksimum 2MB.</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', DB::table('profiles')->where('id', $user->id)->value('phone_number'))" placeholder="e.g. 01123455675" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="user_category" :value="__('User Category')" />
            @php
                $currentCategory = DB::table('profiles')->where('id', $user->id)->value('user_category');
            @endphp
            <select id="user_category" name="user_category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="UPSI Community" {{ old('user_category', $currentCategory) == 'UPSI Community' ? 'selected' : '' }}>UPSI Community</option>
                <option value="Outsider" {{ old('user_category', $currentCategory) == 'Outsider' ? 'selected' : '' }}>Outsider</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('user_category')" />
        </div>

        <div>
            <x-input-label for="origin_organization" :value="__('Origin / Organization')" />
            <x-text-input id="origin_organization" name="origin_organization" type="text" class="mt-1 block w-full" :value="old('origin_organization', DB::table('profiles')->where('id', $user->id)->value('origin_organization'))" placeholder="e.g. Johor" />
            <x-input-error class="mt-2" :messages="$errors->get('origin_organization')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>