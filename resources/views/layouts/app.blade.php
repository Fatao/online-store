<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DRIVE ELITE') }} — @yield('title', 'Премиальные автомобили')</title>
    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
</head>
<body>

{{-- ── Navbar ── --}}
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-logo"> <span>DRIVE ELITE</span></a>

        <div class="nav-links">
            <a href="{{ route('home') }}"           class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">Каталог</a>
            <a href="{{ route('brands.index') }}"    class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">Бренды</a>
            <a href="{{ route('finance.index') }}"   class="{{ request()->routeIs('finance.*') ? 'active' : '' }}">Финансирование</a>
        </div>

        <div class="nav-right">
            <a href="{{ route('cart.index') }}" class="nav-cart">
                Корзина
                @php $cartCount = collect(session('cart', []))->sum('qty') @endphp
                @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
                <div class="nav-user">
                    <span class="nav-username">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->is_regular)
                        <span class="badge-regular">★ VIP</span>
                    @endif
                    <a href="{{ route('orders.index') }}">Заказы</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="accent">Админ</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-link">Выйти</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"    class="btn-outline-sm">Войти</a>
                <a href="{{ route('register') }}" class="btn-primary-sm">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── Flash messages ── --}}
@if(session('success'))
    <div class="flash flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
@endif

{{-- ── Page content ── --}}
<main>
    @yield('content')
</main>

{{-- ── Footer ── --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div>
                <div class="footer-logo"> DRIVE ELITE</div>
                <p class="footer-tagline">Премиальные автомобили для тех, кто выбирает совершенство. Driven by Excellence. Defined by Luxury.</p>
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
                @else
                    <a href="{{ route('login') }}">Войти</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>

        <div class="footer-bottom">
            <div> DRIVE ELITE © {{ date('Y') }}. Все права защищены.</div>
            <div class="footer-credit">Разработано и спроектировано <span>Abdulrahman Fatao</span> &mdash; 2024–2026</div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>