@extends('layouts.app')
@section('title', $car->name)
@section('content')
<div class="detail-wrap">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Главная</a> /
        <a href="{{ route('inventory.index') }}">Каталог</a> /
        <a href="{{ route('brands.show', $car->brand) }}">{{ $car->brand->name }}</a> /
        {{ $car->name }}
    </div>

    <div class="detail-layout">
        {{-- Gallery --}}
        <div>
            {{-- Main image --}}
            <div class="detail-gallery-main">
                @if($car->image)
                    <img src="{{ asset('files/' . $car->image) }}"
                         alt="{{ $car->name }}"
                         class="detail-img"
                         id="main-image"
                         onerror="this.src='';this.alt='Фото недоступно';">
                @else
                    <div class="detail-img-placeholder">🚗</div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @php
                $allImages = [];
                if ($car->image) $allImages[] = $car->image;
                if ($car->gallery && count($car->gallery)) {
                    foreach ($car->gallery as $g) $allImages[] = $g;
                }
            @endphp

            @if(count($allImages) > 1)
                <div class="detail-gallery-thumbs" style="margin-top:12px;">
                    @foreach($allImages as $i => $img)
                        <img src="{{ asset('files/' . $img) }}"
                             class="detail-thumb {{ $i === 0 ? 'active' : '' }}"
                             onclick="switchImage(this, '{{ asset('files/' . $img) }}')"
                             onerror="this.style.display='none';">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <div class="detail-brand">{{ $car->brand->name }}</div>
            <h1 class="detail-name">{{ $car->name }}</h1>

            <div class="detail-specs-row">
                @if($car->year)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ $car->year }}</div>
                        <div class="spec-box-label">Год</div>
                    </div>
                @endif
                @if($car->horsepower)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ $car->horsepower }}</div>
                        <div class="spec-box-label">Л.с.</div>
                    </div>
                @endif
                @if($car->mileage !== null)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ number_format($car->mileage, 0, '', ' ') }}</div>
                        <div class="spec-box-label">Км</div>
                    </div>
                @endif
                @if($car->fuel_type)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ $car->fuel_type }}</div>
                        <div class="spec-box-label">Топливо</div>
                    </div>
                @endif
                @if($car->transmission)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ $car->transmission }}</div>
                        <div class="spec-box-label">КПП</div>
                    </div>
                @endif
                @if($car->body_type)
                    <div class="spec-box">
                        <div class="spec-box-value">{{ $car->body_type }}</div>
                        <div class="spec-box-label">Кузов</div>
                    </div>
                @endif
            </div>

            <div class="detail-price-row">
                <div class="detail-price">{{ number_format($car->price, 0, ',', ' ') }} ₽</div>
                <div class="detail-unit">за {{ $car->unit }}</div>
            </div>

            @if($car->color)
                <p style="color:#8d8a86; margin-bottom:16px; font-size:0.88rem;">
                    Цвет: <span style="color:#ece9e4;">{{ $car->color }}</span>
                </p>
            @endif

            @if($car->description)
                <p class="detail-desc">{{ $car->description }}</p>
            @endif

            @if($car->featuresList())
                <div class="features-list">
                    @foreach($car->featuresList() as $feature)
                        <span class="feature-pill">{{ $feature }}</span>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST" style="margin-top:20px;">
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <div class="qty-row">
                    <label style="margin:0; color:#8d8a86;">Кол-во:</label>
                    <input type="number" name="qty" value="1" min="1" class="qty-input">
                </div>
                <div class="detail-actions">
                    <button type="submit" class="btn-primary btn-large">Купить сейчас</button>
                    <a href="{{ route('finance.index') }}?car_id={{ $car->id }}" class="btn-outline btn-large">Рассчитать кредит</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Related --}}
    @if($related->isNotEmpty())
        <section style="padding:40px 0 20px;">
            <div class="section-header">
                <div>
                    <div class="section-tag">// {{ $car->brand->name }}</div>
                    <h2 class="section-title" style="font-size:1.4rem;">Другие автомобили бренда</h2>
                </div>
            </div>
            <div class="cars-grid">
                @foreach($related as $r)
                    @include('shop._car_card', ['car' => $r])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Reviews --}}
    <div class="reviews-section">
        <h2 class="section-title" style="font-size:1.4rem; margin-bottom:8px;">Отзывы</h2>
        <div class="avg-rating">
            Средняя оценка:
            <span style="color:#c9a86a; font-weight:600;">{{ $car->averageRating() }}</span> / 5
            <span style="color:#555;">({{ $car->reviews->count() }} отзывов)</span>
        </div>

        <div class="reviews-list">
            @forelse($car->reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="review-author">
                            <div class="avatar">{{ mb_substr($review->customer->name ?? '?', 0, 1) }}</div>
                            <span style="color:#ece9e4;">{{ $review->customer->name ?? 'Гость' }}</span>
                        </div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    <p class="review-body">{{ $review->comment }}</p>
                    <div class="review-date">{{ $review->created_at->format('d.m.Y') }}</div>
                </div>
            @empty
                <p style="color:#555; font-size:0.9rem;">Отзывов пока нет. Будьте первым!</p>
            @endforelse
        </div>

        @auth
            <div class="review-form-wrap">
                <h3>Оставить отзыв</h3>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <div class="form-group">
                        <label>Оценка</label>
                        <div class="star-picker">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        <textarea name="comment" placeholder="Поделитесь впечатлениями..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary-sm">Отправить отзыв</button>
                </form>
            </div>
        @else
            <p style="color:#555; font-size:0.88rem;">
                Чтобы оставить отзыв, <a href="{{ route('login') }}" style="color:#c9a86a;">войдите в аккаунт</a>.
            </p>
        @endauth
    </div>

</div>

@push('scripts')
<script>
function switchImage(thumb, src) {
    document.getElementById('main-image').src = src;
    document.querySelectorAll('.detail-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}
</script>
@endpush

@endsection