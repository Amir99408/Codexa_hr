<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activate License — DevStaq HR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.08) 0px, transparent 50%),
                radial-gradient(at 80% 5%,  rgba(255,107,53,0.05) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(15,76,129,0.04) 0px, transparent 50%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        @keyframes scaleUp { from{opacity:0;transform:scale(0.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            max-width: 460px;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.07), 0 16px 40px -4px rgba(15,76,129,.10);
            animation: scaleUp 0.35s cubic-bezier(0.4,0,0.2,1) both;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: linear-gradient(135deg, #ff6b35 0%, #e85d26 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #0f4c81;
            letter-spacing: -0.3px;
        }

        .logo-text span { color: #ff6b35; }

        .header { margin-bottom: 28px; }

        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #0f4c81;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
            animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        .field { margin-bottom: 20px; }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        .fi-wrap { position: relative; }

        .fi-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #9ca3af;
            width: 16px;
            height: 16px;
            transition: color 0.18s;
        }

        .fi-wrap:focus-within .fi-icon { color: #0f4c81; }

        input[type="text"] {
            width: 100%;
            padding: 10px 14px 10px 40px;
            font-size: 14px;
            font-weight: 600;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            color: #111827;
            outline: none;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 1px;
        }

        input[type="text"]:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }

        input[type="text"]::placeholder { color: #9ca3af; font-weight: 400; letter-spacing: 0; }

        .field-hint {
            font-size: 11.5px;
            color: #9ca3af;
            margin-top: 5px;
        }

        .btn-activate {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-activate:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-activate:active { transform: translateY(0); }

        .divider {
            border: none;
            border-top: 1px solid #f3f4f6;
            margin: 24px 0;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .info-box-title {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-steps {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .info-steps li {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #6b7280;
        }

        .step-num {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #0f4c81;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        .footer a { color: #0f4c81; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
    <div class="card">

        <div class="logo">
            <div class="logo-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M3 21h18M9 21v-5h6v5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 7h2M13 7h2M9 11h2M13 11h2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="logo-text">HR<span>Flow</span></span>
        </div>

        <div class="header">
            <div class="step-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="#0f4c81"/>
                </svg>
                One-time setup
            </div>
            <h1>Activate Your License</h1>
            <p class="subtitle">Enter your license key to unlock DevStaq HR. You only need to do this once.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:1px">
                    <circle cx="12" cy="12" r="9" stroke="#dc2626" stroke-width="1.8"/>
                    <path d="M12 7v5.5M12 16.5v.5" stroke="#dc2626" stroke-width="2" stroke-linecap="round"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('license.activate.submit') }}">
            @csrf

            <div class="field">
                <label for="license_key">License Key</label>
                <div class="fi-wrap">
                    <svg class="fi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <input
                        type="text"
                        id="license_key"
                        name="license_key"
                        placeholder="XXXX-XXXX-XXXX-XXXX"
                        value="{{ old('license_key') }}"
                        autocomplete="off"
                        spellcheck="false"
                        autofocus
                    >
                </div>
                @error('license_key')
                    <p class="field-hint" style="color:#dc2626">{{ $message }}</p>
                @enderror
                <p class="field-hint">Your license key was provided when you purchased DevStaq HR.</p>
            </div>

            <button type="submit" class="btn-activate">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Activate License
            </button>
        </form>

        <hr class="divider">

        <div class="info-box">
            <div class="info-box-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#0f4c81" stroke-width="1.8"/>
                    <path d="M12 8v4M12 16v.5" stroke="#0f4c81" stroke-width="2" stroke-linecap="round"/>
                </svg>
                How to get your license key
            </div>
            <ul class="info-steps">
                <li><span class="step-num">1</span> Purchase DevStaq HR from <a href="https://devstaq3.com" target="_blank" style="color:#0f4c81;font-weight:600">devstaq3.com</a></li>
                <li><span class="step-num">2</span> Check your email for the license key</li>
                <li><span class="step-num">3</span> Paste it above and click Activate</li>
            </ul>
        </div>

        <div class="footer">
            Need help? Contact <a href="mailto:support@devstaq3.com">support@devstaq3.com</a>
            or <a href="https://wa.me/923001234567" target="_blank">WhatsApp +92 300 123 4567</a>
        </div>

    </div>
</body>
</html>
