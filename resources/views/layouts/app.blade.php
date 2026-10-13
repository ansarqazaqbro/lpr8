<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Меню') — Ansar havchik</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg:        #FDFBF7;
            --clr-header:    #2C0E14;
            --clr-gold:      #C5A059;
            --clr-gold-lt:   #E8D5A7;
            --clr-text:      #1C1410;
            --clr-muted:     #7A6A5A;
            --clr-border:    #E5DDD0;
            --clr-card:      #FFFFFF;
            --clr-vegan:     #4A7C59;
        }

        /* ── Base ─────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--clr-bg);
            color: var(--clr-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        h1, h2, h3, h4, h5,
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }

        /* ── Navbar ───────────────────────────── */
        .site-nav {
            background-color: var(--clr-header);
            border-bottom: 2px solid var(--clr-gold);
        }
        .site-nav .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            letter-spacing: 0.04em;
            color: var(--clr-gold) !important;
        }
        .site-nav .navbar-brand small {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.25em;
            color: var(--clr-gold-lt);
            text-transform: uppercase;
            line-height: 1;
            margin-top: -2px;
        }
        .site-nav .nav-link {
            color: rgba(253,251,247,.75) !important;
            font-size: 0.82rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 500;
            padding: 0.5rem 1.1rem !important;
            transition: color .2s;
        }
        .site-nav .nav-link:hover,
        .site-nav .nav-link.active {
            color: var(--clr-gold) !important;
        }
        .site-nav .nav-link.active {
            border-bottom: 2px solid var(--clr-gold);
        }

        /* ── Gold divider ─────────────────────── */
        .gold-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.5rem 0 1.5rem;
            color: var(--clr-gold);
        }
        .gold-divider::before,
        .gold-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--clr-gold));
        }
        .gold-divider::after { background: linear-gradient(90deg, var(--clr-gold), transparent); }

        /* ── Dish cards ───────────────────────── */
        .dish-card {
            border: 1px solid var(--clr-border);
            border-radius: 4px;
            background: var(--clr-card);
            overflow: hidden;
            transition: box-shadow .25s, transform .25s;
            height: 100%;
        }
        .dish-card:hover {
            box-shadow: 0 8px 32px rgba(44,14,20,.12);
            transform: translateY(-3px);
        }
        .dish-card__img-wrap {
            height: 220px;
            overflow: hidden;
            background: #f3ede5;
        }
        .dish-card__img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }
        .dish-card:hover .dish-card__img-wrap img { transform: scale(1.04); }
        .dish-card__body { padding: 1.25rem; }
        .dish-card__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            margin-bottom: 0.35rem;
            color: var(--clr-text);
            text-decoration: none;
        }
        .dish-card__title:hover { color: var(--clr-gold); }
        .dish-card__desc {
            font-size: 0.8rem;
            color: var(--clr-muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }
        .dish-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1.25rem;
            border-top: 1px solid var(--clr-border);
        }
        .dish-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--clr-gold);
        }

        /* ── Badges ───────────────────────────── */
        .badge-code {
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            background: var(--clr-bg);
            color: var(--clr-muted);
            border: 1px solid var(--clr-border);
            font-family: monospace;
            border-radius: 2px;
            padding: 2px 6px;
        }
        .badge-section {
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            background: var(--clr-header);
            color: var(--clr-gold-lt);
            border-radius: 2px;
            padding: 3px 8px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500;
            transition: background .2s;
        }
        .badge-section:hover { background: var(--clr-gold); color: var(--clr-header); }
        .badge-vegan {
            font-size: 0.7rem;
            background: var(--clr-vegan);
            color: #fff;
            border-radius: 2px;
            padding: 2px 7px;
            letter-spacing: 0.06em;
        }

        /* ── Btn gold ─────────────────────────── */
        .btn-gold {
            background: var(--clr-gold);
            color: var(--clr-header);
            border: none;
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            border-radius: 2px;
            padding: 0.45rem 1.1rem;
            transition: background .2s, color .2s;
        }
        .btn-gold:hover { background: var(--clr-header); color: var(--clr-gold); }
        .btn-outline-gold {
            background: transparent;
            color: var(--clr-gold);
            border: 1px solid var(--clr-gold);
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            border-radius: 2px;
            padding: 0.45rem 1.1rem;
            transition: background .2s, color .2s;
        }
        .btn-outline-gold:hover { background: var(--clr-gold); color: var(--clr-header); }

        /* ── Search bar ───────────────────────── */
        .search-bar {
            background: #fff;
            border: 1px solid var(--clr-border);
            border-radius: 4px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--clr-gold);
            box-shadow: 0 0 0 3px rgba(197,160,89,.18);
        }

        /* ── Page title ───────────────────────── */
        .page-eyebrow {
            font-size: 0.7rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--clr-gold);
            font-weight: 600;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--clr-header);
            line-height: 1.2;
        }

        /* ── Alert flash ──────────────────────── */
        .alert-status {
            background: #f6f2ea;
            border-left: 3px solid var(--clr-gold);
            border-radius: 2px;
            color: var(--clr-text);
            padding: 0.9rem 1.2rem;
            font-size: 0.9rem;
        }

        /* ── Footer ───────────────────────────── */
        .site-footer {
            background-color: var(--clr-header);
            color: rgba(253,251,247,.5);
            padding: 1.4rem 0;
            margin-top: auto;
            border-top: 2px solid var(--clr-gold);
            font-size: 0.78rem;
        }
        .site-footer strong { color: var(--clr-gold-lt); }
        .site-footer .footer-time { color: rgba(197,160,89,.7); }
    </style>

    @stack('styles')
</head>
<body>

{{-- ════════════ НАВИГАЦИЯ ════════════ --}}
<nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('catalog.index') }}">
            Ansar havchik
            <small>Ресторан политех кж</small>
        </a>
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-warning fs-4"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navMenu">
            <ul class="navbar-nav gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.index') ? 'active' : '' }}"
                       href="{{ route('catalog.index') }}">Меню</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.section') ? 'active' : '' }}"
                       href="{{ route('catalog.section') }}">Разделы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dishes.*') ? 'active' : '' }}"
                       href="{{ route('dishes.index') }}">
                       <i class="bi bi-sliders me-1"></i>Управление меню (CRUD)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedback.*') ? 'active' : '' }}"
                       href="{{ route('feedback.form') }}">Связь</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Flash-сообщение --}}
@if(session('status'))
<div class="container mt-3">
    <div class="alert-status d-flex align-items-start gap-2">
        <i class="bi bi-check-circle text-success mt-1"></i>
        <span>{{ session('status') }}</span>
    </div>
</div>
@endif

{{-- ════════════ КОНТЕНТ ════════════ --}}
<main class="container my-5 flex-grow-1">
    @yield('content')
</main>

{{-- ════════════ ПОДВАЛ ════════════ --}}
<footer class="site-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span>Студент: <strong>{{ config('lab.student') }}</strong></span>
                &nbsp;·&nbsp;
                <span>Группа: <strong>{{ config('lab.group') }}</strong></span>
                &nbsp;·&nbsp;
                <span>N = <strong>{{ config('lab.number') }}</strong></span>
                &nbsp;·&nbsp;
                <span>Код занятия: <strong>{{ config('lab.code') }}</strong></span>
            </div>
            <div class="col-md-4 text-md-end footer-time">
                <i class="bi bi-clock me-1"></i>{{ now()->format('d.m.Y H:i:s') }}
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmFfk7rKhR1FN0BLdZg7Q/LmBI"
        crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>
