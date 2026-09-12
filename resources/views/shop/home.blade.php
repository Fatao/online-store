@extends('layouts.app')
@section('title', 'Главная')
@section('content')

{{-- Hero --}}
<section class="hero">
    <div class="hero-inner fade-in">
        <div class="hero-tag"> DRIVE ELITE </div>
        <h1 class="hero-title">Роскошь — это не мечта.<br><span class="accent">Это решение.</span></h1>
        <p class="hero-sub">
            Мы не просто продаём автомобили — мы предлагаем статус, мощь и безупречный стиль.
            От Mercedes-Benz до BMW, Audi, Porsche, Ferrari, Lamborghini и Rolls-Royce —
            каждый автомобиль в нашей коллекции отобран для тех, кто не приемлет компромиссов.
        </p>
        <div class="hero-btns">
            <a href="{{ route('inventory.index') }}" class="btn-primary">Смотреть каталог</a>
            <a href="{{ route('finance.index') }}" class="btn-outline">Записаться на тест-драйв</a>
        </div>
        <div class="hero-stats">
            <div>
                <div class="stat-num">{{ \App\Models\Car::count() }}+</div>
                <div class="stat-label">Автомобилей</div>
            </div>
            <div>
                <div class="stat-num">{{ \App\Models\Customer::where('role','user')->count() }}+</div>
                <div class="stat-label">Клиентов</div>
            </div>
            <div>
                <div class="stat-num">{{ \App\Models\Brand::count() }}+</div>
                <div class="stat-label">Брендов</div>
            </div>
        </div>
    </div>
</section>

{{-- Regular customer banner --}}
@auth
    @if(auth()->user()->is_regular)
        <div class="regular-banner">★ Вы VIP-клиент Drive Elite — ваша скидка <strong>2%</strong> применяется автоматически.</div>
    @elseif(auth()->user()->total_spent > 0)
        @php $remaining = 5000 - auth()->user()->total_spent @endphp
        @if($remaining > 0)
            <div class="regular-banner-progress">До статуса VIP-клиента осталось потратить: <strong>{{ number_format($remaining, 2, ',', ' ') }} ₽</strong></div>
        @endif
    @endif
@endauth

{{-- Luxury brands --}}
<section class="section">
    <div class="section-header">
        <div>
            <div class="section-tag"> Наши бренды</div>
            <h2 class="section-title">Легендарные марки</h2>
        </div>
        <a href="{{ route('brands.index') }}" class="section-link">Все бренды →</a>
    </div>

    <div class="brands-grid">
        @foreach($featuredBrands as $brand)
            <a href="{{ route('brands.show', $brand) }}" class="brand-tile">
                <div class="brand-tile-name">{{ $brand->name }}</div>
                <div class="brand-tile-count">{{ $brand->cars_count }} авто</div>
            </a>
        @endforeach
    </div>
</section>

{{-- Featured cars --}}
<section class="section">
    <div class="section-header">
        <div>
            <div class="section-tag"> Подборка</div>
            <h2 class="section-title">Избранные автомобили</h2>
        </div>
        <a href="{{ route('inventory.index') }}" class="section-link">Весь каталог →</a>
    </div>

    @if($featured->isEmpty())
        <div class="empty-state">Автомобили пока не добавлены.</div>
    @else
        <div class="cars-grid">
            @foreach($featured as $car)
                @include('shop._car_card', ['car' => $car])
            @endforeach
        </div>
    @endif
</section>

{{-- Why choose us --}}
<section class="section">
    <div class="section-header section-center" style="flex-direction:column; text-align:center; margin: 0 auto 40px;">
        <div class="section-tag"> Почему мы</div>
        <h2 class="section-title">Почему выбирают Drive Elite</h2>
        <p class="section-sub">Создано для тех, кто ценит время, класс и точность.</p>
    </div>

    <div class="why-grid">
        <div class="why-card">
            <div class="why-card-title">Отборные премиальные автомобили</div>
            <p class="why-card-text">Каждый автомобиль проходит тщательную проверку и соответствует высочайшим стандартам качества, производительности и роскоши.</p>
        </div>
        <div class="why-card">
            <div class="why-card-title">Прозрачные сделки</div>
            <p class="why-card-text">Честные цены, проверенные автомобили и профессиональный сервис на каждом этапе — от запроса до доставки.</p>
        </div>
        <div class="why-card">
            <div class="why-card-title">Безупречный сервис</div>
            <p class="why-card-text">От просмотра каталога до финансирования и владения — мы делаем каждый шаг лёгким и приятным.</p>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-band">
    <h2 class="cta-title">Вы не просто покупаете люксовый автомобиль. Вы инвестируете в уверенность.</h2>
    <p class="cta-sub">Выбираете совершенство. Владеете дорогой. Drive Elite — для тех, кто уже достиг вершины.</p>
    <div class="cta-btns">
        <a href="{{ route('inventory.index') }}" class="btn-primary">Изучить каталог</a>
        <a href="{{ route('finance.index') }}" class="btn-outline">Связаться со специалистом</a>
    </div>
</section>

@endsection