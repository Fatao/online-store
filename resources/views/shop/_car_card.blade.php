<div class="car-card">
    <div class="car-card-img">
        @if($car->image)
            <img src="{{ asset('files/' . $car->image) }}"
                 alt="{{ $car->name }}"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="car-img-placeholder" style="display:none;">🚗</div>
        @else
            <div class="car-img-placeholder">🚗</div>
        @endif
        <span class="car-card-brand">{{ $car->brand->name }}</span>
    </div>
    <div class="car-card-body">
        <a href="{{ route('inventory.show', $car) }}" class="car-name">{{ $car->name }}</a>
        <div class="car-meta">
            @if($car->year)<span>{{ $car->year }}</span>@endif
            @if($car->horsepower)<span>&middot; {{ $car->horsepower }} л.с.</span>@endif
            @if($car->transmission)<span>&middot; {{ $car->transmission }}</span>@endif
        </div>
        <div class="car-price-row">
            <div>
                <div class="car-price">{{ number_format($car->price, 0, ',', ' ') }} ₽</div>
                <div class="car-unit">за {{ $car->unit }}</div>
            </div>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <button type="submit" class="btn-add-cart" title="В корзину">+</button>
            </form>
        </div>
    </div>
</div>