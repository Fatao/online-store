@extends('layouts.app')
@section('title', 'Корзина')
@section('content')
<div class="cart-wrap">
    <h1 class="page-title"> Корзина</h1>

    @if(empty($items))
        <div class="empty-state">
            <div class="empty-icon">🛒</div>
            <p>Ваша корзина пуста.</p>
            <a href="{{ route('inventory.index') }}" class="btn-outline-sm">Перейти в каталог</a>
        </div>
    @else
        <div class="cart-layout">
            <div class="cart-items">
                @foreach($items as $item)
                    <div class="cart-item">
                        <div class="cart-item-img">
                            @if($item['car']->image)
                                <img src="{{ asset('storage/' . $item['car']->image) }}" alt="">
                            @else
                                🚗
                            @endif
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item['car']->name }}</div>
                            <div class="cart-item-price">{{ number_format($item['car']->price, 0, ',', ' ') }} ₽ / {{ $item['car']->unit }}</div>
                        </div>
                        <div class="cart-item-actions">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $item['car']->id }}">
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="qty-input" onchange="this.form.submit()">
                            </form>
                            <div class="cart-item-subtotal">{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</div>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="car_id" value="{{ $item['car']->id }}">
                                <button type="submit" class="btn-remove" title="Удалить">✕</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <div class="summary-title">Итого</div>
                <div class="summary-row"><span>Подытог</span><span>{{ number_format($total, 0, ',', ' ') }} ₽</span></div>
                @if($discount > 0)
                    <div class="summary-row discount-row"><span>Скидка VIP (2%)</span><span>−{{ number_format($discount, 0, ',', ' ') }} ₽</span></div>
                @endif
                <div class="summary-divider"></div>
                <div class="summary-total"><span>К оплате</span><span>{{ number_format($grandTotal, 0, ',', ' ') }} ₽</span></div>

                @auth
                    <a href="{{ route('checkout.index') }}" class="btn-primary btn-full" style="margin-top:18px;">Перейти к оформлению</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary btn-full" style="margin-top:18px;">Войти для оформления</a>
                @endauth

                <form action="{{ route('cart.clear') }}" method="POST" style="margin-top:10px;">
                    @csrf
                    <button type="submit" class="btn-ghost btn-full">Очистить корзину</button>
                </form>

                @if($discount == 0)
                    <div class="discount-badge">Покупки от 5 000 ₽ дают статус VIP-клиента со скидкой 2%</div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection