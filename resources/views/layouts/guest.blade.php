<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<<<<<<< HEAD
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
=======
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-emerald-50 via-white to-lime-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="/" class="flex items-center gap-3 rounded-full bg-white/80 px-4 py-2 shadow-sm ring-1 ring-emerald-100 backdrop-blur">
                    <x-application-logo class="w-12 h-12 fill-current text-emerald-600" />
                    <div class="text-left">
                        <p class="text-sm font-semibold text-gray-900">EduForest</p>
                        <p class="text-xs text-gray-500">Outdoor Adventure Booking</p>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100/70 backdrop-blur">
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
