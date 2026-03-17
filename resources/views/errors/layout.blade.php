<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('page_title', 'Error')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-900: #051b44;
            --blue-800: #0b2e6f;
            --blue-700: #0d3c8c;
            --gold-500: #f2c14e;
            --gold-600: #e6ae2f;
            --ink-100: #f4f7ff;
            --ink-200: rgba(244, 247, 255, 0.85);
            --ink-300: rgba(244, 247, 255, 0.65);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Plus Jakarta Sans", "Segoe UI", sans-serif;
            color: var(--ink-100);
            background:
                radial-gradient(900px 520px at 80% 20%, rgba(242, 193, 78, 0.25), transparent 60%),
                radial-gradient(700px 420px at 20% 80%, rgba(16, 88, 194, 0.4), transparent 55%),
                linear-gradient(140deg, var(--blue-900), var(--blue-800) 45%, var(--blue-700));
            padding: 48px 18px;
        }

        .stage {
            position: relative;
            width: min(980px, 100%);
            padding: 64px 48px 56px;
            border-radius: 28px;
            background: rgba(7, 22, 50, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 80px rgba(3, 10, 25, 0.45);
            overflow: hidden;
            text-align: center;
        }

        .hero-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.12;
            filter: grayscale(100%) brightness(0.9);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.08), transparent 55%);
        }

        .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .logo-float {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            display: grid;
            place-items: center;
            box-shadow: 0 18px 35px rgba(2, 10, 30, 0.45);
            animation: float 4.2s ease-in-out infinite;
            margin-bottom: 6px;
        }

        .logo-float img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .tools-icon {
            width: 54px;
            height: 54px;
            fill: #ffffff;
            filter: drop-shadow(0 6px 16px rgba(5, 15, 35, 0.45));
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(242, 193, 78, 0.18);
            color: var(--gold-500);
            font-size: 0.8rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-weight: 600;
        }

        h1 {
            margin: 0;
            font-family: "Outfit", "Plus Jakarta Sans", sans-serif;
            font-size: clamp(2.4rem, 4vw, 3.2rem);
            letter-spacing: -0.01em;
        }

        .lead {
            margin: 0;
            font-size: 1.05rem;
            color: var(--ink-200);
            max-width: 560px;
        }

        .sub {
            margin: 0;
            font-size: 0.95rem;
            color: var(--ink-300);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            margin-top: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 999px;
            border: 1px solid transparent;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn.primary {
            background: var(--gold-500);
            color: #1e2a35;
            box-shadow: 0 16px 30px rgba(242, 193, 78, 0.3);
        }

        .btn.primary:hover {
            background: var(--gold-600);
            transform: translateY(-1px);
        }

        .btn.ghost {
            background: transparent;
            color: var(--ink-100);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .btn.ghost:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(5, 15, 35, 0.35);
        }

        .meta {
            font-size: 0.85rem;
            color: var(--ink-300);
        }

        .meta a {
            color: var(--gold-500);
            text-decoration: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 720px) {
            .stage {
                padding: 52px 26px 46px;
            }

            .logo-float {
                width: 80px;
                height: 80px;
            }

            .logo-float img {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>
<body>
@php
    $heroImage = $heroImage ?? asset('assets/images/bafoussam.png');
@endphp
<div class="stage">
    <div class="hero-image" style="background-image: url('{{ $heroImage }}');"></div>
    <div class="hero-overlay"></div>
    <div class="content">
        <div class="logo-float">
            <svg class="tools-icon" viewBox="0 0 64 64" aria-hidden="true" focusable="false">
                <rect x="9" y="28" width="46" height="8" rx="4" transform="rotate(45 32 32)" />
                <rect x="9" y="28" width="46" height="8" rx="4" transform="rotate(-45 32 32)" />
                <circle cx="18" cy="46" r="4" opacity="0.9" />
                <circle cx="46" cy="18" r="4" opacity="0.9" />
            </svg>
        </div>
        <span class="badge">@yield('code', 'Error')</span>
        <h1>@yield('heading', 'We are working on it')</h1>
        <p class="lead">@yield('message')</p>
        <p class="sub">@yield('detail')</p>
        <div class="actions">
            <a class="btn primary" href="{{ url('/') }}">Go to Home</a>
            @if(auth()->check())
                <a class="btn ghost" href="{{ auth()->user()->getDashboardRoute() }}">Dashboard</a>
            @else
                <a class="btn ghost" href="{{ url('/sign-in') }}">Sign in</a>
            @endif
        </div>
        <div class="meta">Need help? <a href="mailto:aesnkey@gmail.com">aesnkey@gmail.com</a></div>
    </div>
</div>
</body>
</html>
