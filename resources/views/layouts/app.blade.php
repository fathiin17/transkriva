<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Transkriva</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<!-- ===== HEADER ===== -->
<header class="bg-gradient-to-r from-[#0f172a] via-[#1e3a8a] to-[#2563eb] shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LEFT: LOGO + DASHBOARD -->
        <div class="flex items-center gap-8">

            <!-- LOGO -->
            <a href="{{ route('recordings.index') }}"
               class="flex items-center gap-4 hover:opacity-90 transition">
                <div class="w-10 h-10 rounded-lg
                            bg-black/10 border border-Black/20
                            flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-blue"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 14a3 3 0 0 0 3-3V6a3 3 0 1 0-6 0v5a3 3 0 0 0 3 3Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 11a7 7 0 0 1-14 0"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 18v3"/>
                    </svg>
                </div>

                <div class="leading-tight">
                    <h1 class="text-blue font-semibold text-lg tracking-wide">
                        Transkriva
                    </h1>
                    <p class="text-xs text-gray-300">
                        Record • Transcribe • Download
                    </p>
                </div>
            </a>

            <!-- DASHBOARD -->
            <a href="{{ route('recordings.index') }}"
               class="px-6 py-2 rounded-lg
                      border border-black/20
                      text-blue text-sm
                      hover:bg-black/10 transition">
                Dashboard
            </a>
        </div>

        <!-- RIGHT: USER MENU -->
        @auth
        <div class="flex items-center gap-5">

            <span class="text-sm text-gray-200">
                Hi, <span class="font-medium text-blue">{{ Auth::user()->name }}</span>
            </span>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="px-4 py-2 rounded-lg
                           border border-white/20
                           text-sm text-blue
                           hover:bg-white/10 transition flex items-center gap-2">
                    Akun
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" @click.outside="open = false"
                     class="absolute right-0 mt-2 w-44
                            bg-white rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm hover:bg-gray-100">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm
                                       text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endauth

    </div>
</header>
<!-- ===== END HEADER ===== -->

<!-- PAGE CONTENT -->
<main class="max-w-7xl mx-auto p-6">
    {{ $slot }}
</main>

</body>
</html>
