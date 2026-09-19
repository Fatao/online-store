<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','DRIVE ELITE') }} — @yield('title','Премиальные автомобили')</title>
    <link rel="stylesheet" href="/css/app.css">
    <style>
        /* ── Mobile hamburger ── */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
            background: none;
            border: none;
        }
        .hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text);
            border-radius: 2px;
            transition: all .3s;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            top: 72px;
            left: 0; right: 0;
            background: rgba(11,11,13,0.98);
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
            z-index: 99;
            backdrop-filter: blur(10px);
        }
        .mobile-menu.open { display: block; }
        .mobile-menu a {
            display: block;
            padding: 12px 0;
            font-size: 0.9rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }
        .mobile-menu a:hover { color: var(--gold); }
        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu .mobile-auth {
            display: flex;
            gap: 10px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }
        @media (max-width: 768px) {
            .hamburger { display: flex; }
            .nav-links  { display: none !important; }
            .nav-right .btn-primary-sm,
            .nav-right .btn-outline-sm { display: none; }
            .nav-user .nav-username,
            .nav-user .badge-regular { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-logo"> <span>DRIVE ELITE</span></a>

        <div class="nav-links">
            <a href="{{ route('home') }}"            class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('inventory.index') }}"  class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">Каталог</a>
            <a href="{{ route('brands.index') }}"     class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">Бренды</a>
            <a href="{{ route('finance.index') }}"    class="{{ request()->routeIs('finance.*') ? 'active' : '' }}">Финансирование</a>
        </div>

        <div class="nav-right">
            <a href="{{ route('cart.index') }}" class="nav-cart">
                Корзина
                @php $cartCount = collect(session('cart',[])) ->sum('qty') @endphp
                @if($cartCount > 0)<span class="cart-count">{{ $cartCount }}</span>@endif
            </a>

            @auth
                <div class="nav-user">
                    <a href="{{ route('profile.show') }}" class="nav-username" style="text-decoration:none;color:var(--text);">{{ auth()->user()->name }}</a>
                    @if(auth()->user()->is_regular)<span class="badge-regular">★ VIP</span>@endif
                    <a href="{{ route('orders.index') }}">Заказы</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="accent">Админ</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf<button type="submit" class="btn-link">Выйти</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"    class="btn-outline-sm">Войти</a>
                <a href="{{ route('register') }}" class="btn-primary-sm">Регистрация</a>
            @endauth

            {{-- Hamburger --}}
            <button class="hamburger" id="hamburger" aria-label="Меню">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile menu --}}
<div class="mobile-menu" id="mobile-menu">
    <a href="{{ route('home') }}">Главная</a>
    <a href="{{ route('inventory.index') }}">Каталог</a>
    <a href="{{ route('brands.index') }}">Бренды</a>
    <a href="{{ route('finance.index') }}">Финансирование</a>
    <a href="{{ route('cart.index') }}">Корзина @if($cartCount > 0)({{ $cartCount }})@endif</a>
    @auth
        <a href="{{ route('orders.index') }}">Мои заказы</a>
        <a href="{{ route('profile.show') }}">Мой профиль</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" style="color:var(--gold);">Админ-панель</a>
        @endif
        <div class="mobile-auth">
            <form action="{{ route('logout') }}" method="POST">
                @csrf<button type="submit" class="btn-outline" style="padding:10px 20px;font-size:0.8rem;">Выйти</button>
            </form>
        </div>
    @else
        <div class="mobile-auth">
            <a href="{{ route('login') }}"    class="btn-outline"  style="padding:10px 20px;font-size:0.8rem;text-align:center;flex:1;">Войти</a>
            <a href="{{ route('register') }}" class="btn-primary"  style="padding:10px 20px;font-size:0.8rem;text-align:center;flex:1;">Регистрация</a>
        </div>
    @endauth
</div>

@if(session('success'))<div class="flash flash-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif

<main>@yield('content')</main>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div>
                <div class="footer-logo"> DRIVE ELITE</div>
                <p class="footer-tagline">Премиальные автомобили для тех, кто выбирает совершенство.<br>Driven by Excellence. Defined by Luxury.</p>
            </div>
            <div class="footer-links-col">
                <h4>Навигация</h4>
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('inventory.index') }}">Каталог</a>
                <a href="{{ route('brands.index') }}">Бренды</a>
                <a href="{{ route('finance.index') }}">Финансирование</a>
            </div>
            <div class="footer-links-col">
                <h4>Аккаунт</h4>
                <a href="{{ route('cart.index') }}">Корзина</a>
                @auth
                    <a href="{{ route('orders.index') }}">Мои заказы</a>
                    <a href="{{ route('profile.show') }}">Мой профиль</a>
                @else
                    <a href="{{ route('login') }}">Войти</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
        <div class="footer-bottom">
            <div> DRIVE ELITE © {{ date('Y') }}. Все права защищены.</div>
            <div class="footer-credit">Разработано и спроектировано <span>Abdulrahman Fatao</span> — 2024–2026</div>
        </div>
    </div>
</footer>

<script>
const ham  = document.getElementById('hamburger');
const menu = document.getElementById('mobile-menu');
ham.addEventListener('click', () => {
    menu.classList.toggle('open');
});
document.addEventListener('click', e => {
    if (!ham.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('open');
    }
});
</script>

@stack('scripts')
</body>
</html>