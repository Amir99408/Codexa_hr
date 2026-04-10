<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .login-bg {
            min-height: 100vh;
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 5%,  rgba(255,107,53,0.05) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(15,76,129,0.04) 0px, transparent 50%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        @keyframes scaleUp  { from{opacity:0;transform:scale(0.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes slideDown{ from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        .scale-up   { animation: scaleUp   0.35s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s  cubic-bezier(0.4,0,0.2,1) both; }

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
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
    </style>

    <div class="login-bg">
        <div class="w-full max-w-md">

            {{-- ── Brand ──────────────────────────────────────── --}}
            <div class="text-center mb-8 slide-down">
                <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg shadow-blue-900/20"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Reset your password</h1>
                <p class="text-sm text-gray-400 font-medium mt-1">We'll send a reset link to your email</p>
            </div>

            {{-- ── Card ───────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden scale-up">

                {{-- Top stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

                <div class="p-7">

                    {{-- Info box --}}
                    <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-xl mb-6">
                        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-medium text-blue-700 leading-relaxed">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>
                    </div>

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

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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

                        {{-- Divider --}}
                        <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ __('Email Password Reset Link') }}
                        </button>

                        {{-- Back to login --}}
                        <div class="text-center">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-[#0f4c81] transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Back to Sign In
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ── Footer ──────────────────────────────────────── --}}
            <p class="text-center text-[11px] text-gray-400 font-medium mt-6">
                HR Management System &copy; {{ date('Y') }}
            </p>

        </div>
    </div>
</x-guest-layout>