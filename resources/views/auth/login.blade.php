<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .login-bg {
            height: 100vh;
            overflow: hidden;
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 5%,  rgba(255,107,53,0.05) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(15,76,129,0.04) 0px, transparent 50%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
        }

        @keyframes scaleUp  { from{opacity:0;transform:scale(0.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes slideDown{ from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        .scale-up   { animation: scaleUp   0.35s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        /* ── Inputs ───────────────────────────────────────────── */
        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder { color:#9ca3af; font-weight:400; }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.875rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon { color:#0f4c81; }

        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.35rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── Checkbox ─────────────────────────────────────────── */
        .custom-check {
            width: 1rem; height: 1rem;
            border-radius: 0.25rem;
            border: 1.5px solid #d1d5db;
            accent-color: #0f4c81;
            cursor: pointer;
        }
        .custom-check:focus { outline: none; box-shadow: 0 0 0 3px rgba(15,76,129,0.12); }
    </style>

    <div class="login-bg">
        <div class="w-full max-w-md">

            {{-- ── Brand ──────────────────────────────────────── --}}
            <div class="text-center mb-5 slide-down">
                <div class="w-12 h-12 rounded-2xl mx-auto mb-3 flex items-center justify-center shadow-lg shadow-blue-900/20"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">Welcome back</h1>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Sign in to your HR dashboard</p>
            </div>

            {{-- ── Card ───────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden scale-up">

                {{-- Top stripe --}}
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

                <div class="p-5">

                    {{-- Session Status --}}
                    @if(session('status'))
                        <div class="mb-5 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                            <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="field-label">Email Address</label>
                            <div class="fi-wrap">
                                <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="you@company.com"
                                       required
                                       autofocus
                                       autocomplete="username"
                                       class="form-input {{ $errors->get('email') ? 'border-red-300' : '' }}"/>
                            </div>
                            @foreach($errors->get('email') as $error)
                                <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="field-label">Password</label>
                            <div class="fi-wrap">
                                <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <input id="password"
                                       type="password"
                                       name="password"
                                       placeholder="••••••••"
                                       required
                                       autocomplete="current-password"
                                       class="form-input {{ $errors->get('password') ? 'border-red-300' : '' }}"/>
                            </div>
                            @foreach($errors->get('password') as $error)
                                <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember" class="custom-check"/>
                                <span class="text-xs font-semibold text-gray-600">{{ __('Remember me') }}</span>
                            </label>

                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-bold text-[#0f4c81] hover:text-blue-800 transition-colors duration-150">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        {{-- Divider --}}
                        <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Sign In') }}
                        </button>

                    </form>
                </div>
            </div>

            {{-- ── Footer note ─────────────────────────────────── --}}
            <p class="text-center text-[11px] text-gray-400 font-medium mt-3">
                HR Management System &copy; {{ date('Y') }}
            </p>

        </div>
    </div>
</x-guest-layout>