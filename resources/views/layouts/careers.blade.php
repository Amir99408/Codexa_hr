<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{ $title ?? 'Careers' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('careers.index') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-gray-900 text-sm">{{ \App\Models\Setting::get('company_name', config('app.name')) }}</span>
                    <span class="text-xs text-gray-400 block leading-none">Careers</span>
                </div>
            </a>
            <a href="{{ route('login') }}"
               class="text-xs font-semibold text-[#0f4c81] hover:text-blue-800 transition">
                Employee Login →
            </a>
        </div>
    </nav>

    {{ $slot }}

    {{-- Footer --}}
    <footer class="mt-16 py-8 border-t border-gray-100 text-center text-xs text-gray-400">
        © {{ date('Y') }} {{ \App\Models\Setting::get('company_name', config('app.name')) }} — All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
