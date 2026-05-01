<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @php
        $appName = \App\Models\Setting::get('company_name') ?: config('app.name', 'HRFlow');
        $favicon = \App\Models\Setting::get('company_favicon', '');
    @endphp
    <title>{{ $title ?? 'Dashboard' }} — {{ $appName }}</title>
    @if($favicon)
        <link rel="icon" href="{{ $favicon }}" type="image/x-icon"/>
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        #sidebar {
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar-overlay {
            transition: opacity 0.28s ease;
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- ── Overlay (mobile only) ─────────────────────────── --}}
        <div id="sidebar-overlay"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden"
             onclick="closeSidebar()">
        </div>

        {{-- ── Sidebar ────────────────────────────────────────── --}}
        <aside id="sidebar"
               class="fixed lg:static inset-y-0 left-0 z-40
                      w-64 flex-shrink-0
                      -translate-x-full lg:translate-x-0">
            @include('components.sidebar')
        </aside>

        {{-- ── Main area ──────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- ✅ ONE header for ALL screen sizes --}}
            {{-- The hamburger button inside it is lg:hidden --}}
            <x-top-bar :title="$title ?? 'Dashboard'" />

            {{-- ── Page content ─────────────────────────────── --}}
            <main class="flex-1 overflow-y-auto p-5 lg:p-8">
                {{ $slot }}
            </main>

        </div>
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) closeSidebar();
                });
            });
        });
    </script>

    @livewireScripts
<script>
function previewPhoto(input, containerId) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const container = document.getElementById(containerId);
        container.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
</body>
</html>