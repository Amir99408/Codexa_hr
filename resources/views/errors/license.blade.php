<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>License {{ $status === 'suspended' ? 'Suspended' : 'Expired' }} — HRFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 48px 40px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.18);
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #ff6b35 0%, #e85d26 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: #0f4c81;
            letter-spacing: -0.3px;
        }

        .logo-text span {
            color: #ff6b35;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .badge-suspended {
            background: #fff3cd;
            color: #b45309;
        }

        .badge-expired {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .dot-suspended { background: #f59e0b; }
        .dot-expired   { background: #ef4444; }

        .icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrap-suspended { background: #fff7ed; }
        .icon-wrap-expired   { background: #fef2f2; }

        h1 {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        p.desc {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .divider {
            border: none;
            border-top: 1px solid #f3f4f6;
            margin-bottom: 28px;
        }

        .contact-title {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 16px;
        }

        .contact-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .contact-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.15s, border-color 0.15s;
        }

        .contact-link:hover { background: #f3f4f6; border-color: #d1d5db; }

        .contact-link svg { flex-shrink: 0; }

        .footer-note {
            margin-top: 28px;
            font-size: 12px;
            color: #9ca3af;
        }

        .footer-note a {
            color: #0f4c81;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="card">

        {{-- Logo --}}
        <div class="logo">
            <div class="logo-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M3 21h18M9 21v-5h6v5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 7h2M13 7h2M9 11h2M13 11h2" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="logo-text">HR<span>Flow</span></span>
        </div>

        {{-- Badge --}}
        @if($status === 'suspended')
            <div class="status-badge badge-suspended">
                <span class="status-dot dot-suspended"></span>
                License Suspended
            </div>
        @else
            <div class="status-badge badge-expired">
                <span class="status-dot dot-expired"></span>
                License Expired
            </div>
        @endif

        {{-- Icon --}}
        <div class="icon-wrap {{ $status === 'suspended' ? 'icon-wrap-suspended' : 'icon-wrap-expired' }}">
            @if($status === 'suspended')
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#f59e0b" stroke-width="1.8"/>
                    <path d="M12 7v5.5M12 16.5v.5" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                </svg>
            @else
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#ef4444" stroke-width="1.8"/>
                    <path d="M8.5 8.5l7 7M15.5 8.5l-7 7" stroke="#ef4444" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            @endif
        </div>

        {{-- Heading --}}
        @if($status === 'suspended')
            <h1>Your License Has Been Suspended</h1>
            <p class="desc">
                Access to HRFlow has been temporarily suspended.<br>
                Please contact support to resolve this issue and restore access.
            </p>
        @else
            <h1>Your License Has Expired</h1>
            <p class="desc">
                Your HRFlow license has expired and access has been restricted.<br>
                Please renew your license to continue using the application.
            </p>
        @endif

        <hr class="divider">

        {{-- Contact --}}
        <p class="contact-title">Get in touch to restore access</p>

        <div class="contact-links">
            <a href="mailto:support@devstaq3.com" class="contact-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <rect x="2" y="4" width="20" height="16" rx="2" stroke="#0f4c81" stroke-width="1.8"/>
                    <path d="M2 8l10 6 10-6" stroke="#0f4c81" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                support@devstaq3.com
            </a>

            <a href="https://wa.me/923001234567" target="_blank" class="contact-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.979-1.406A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="#25d366" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M8.5 9.5c.5 1 1.5 3 3.5 4s3-1 3-1-.5-1.5-1-1.5-1 .5-1 .5c-.5 0-2-1-2.5-2.5 0 0 .5-.5.5-1S9 7.5 9 7.5 8 8.5 8.5 9.5z" stroke="#25d366" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                +92 300 123 4567
            </a>

            <a href="https://devstaq3.com" target="_blank" class="contact-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="#6366f1" stroke-width="1.8"/>
                    <path d="M2 12h20M12 2c-2.5 3-4 6.5-4 10s1.5 7 4 10M12 2c2.5 3 4 6.5 4 10s-1.5 7-4 10" stroke="#6366f1" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                devstaq3.com
            </a>
        </div>

        <p class="footer-note">
            Powered by <a href="https://devstaq3.com" target="_blank">DevStaq</a> License System
        </p>

    </div>
</body>
</html>
