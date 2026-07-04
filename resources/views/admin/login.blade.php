<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center px-4 bg-transparent">
        <div class="w-full max-w-md bg-white p-8 border border-gray-100 text-center" style="background-color: white; border-radius: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 28rem; margin: auto; padding: 2rem;">
            
            <div class="flex justify-center mb-4">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" 
                    alt="Edu-Forest Logo" style="height: 5rem; width: auto; object-fit: contain;">
            </div>

            <div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-900">
        Admin Login
    </h2>

    <p class="text-gray-500 mt-2">
        Sign in to access the EduForest Admin Dashboard.
    </p>
</div>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
    @csrf

    <div>
        <label class="block text-left mb-2 text-sm font-semibold text-gray-700">
            Email Address
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            placeholder="Enter your email address"

            class="w-full rounded-2xl border border-gray-200 bg-white
                   px-5 py-4 text-sm
                   focus:border-[#355E3B]
                   focus:ring-[#355E3B]">
    </div>

    <div>
        <label class="block text-left mb-2 text-sm font-semibold text-gray-700">
            Password
        </label>

        <input
            type="password"
            name="password"
            required
            placeholder="Enter your password"

            class="w-full rounded-2xl border border-gray-200 bg-white
                   px-5 py-4 text-sm
                   focus:border-[#355E3B]
                   focus:ring-[#355E3B]">
    </div>

    @if ($errors->any())
        <div class="text-red-500 text-sm text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <button
        type="submit"
        class="w-full rounded-2xl bg-[#355E3B]
               hover:bg-[#294c31]
               py-4 text-lg font-bold text-white
               transition duration-300
               shadow-lg">

        Log In as Admin

    </button>

</form>

<div class="mt-7 border-t border-gray-100 pt-6">

    <a href="{{ route('login') }}"
       class="flex items-center justify-center gap-2
              text-[#355E3B]
              font-bold
              hover:underline">

        ← Back to Client Login

    </a>

</div>
        </div>
    </div>
</x-guest-layout>