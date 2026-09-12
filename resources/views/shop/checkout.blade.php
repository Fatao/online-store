@extends('layouts.app')
@section('title', 'Оформление заказа')
@section('content')
<div class="checkout-wrap">
    <h1 class="page-title"> Оформление заказа</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="checkout-layout">
        <div class="checkout-form-wrap">
            <div class="form-section-title">Данные доставки</div>
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Адрес доставки</label>
                    <input type="text" name="shipping_address" value="{{ old('shipping_address', auth()->user()->address) }}" required placeholder="Город, улица, дом">
                </div>

                <div class="form-group">
                    <label>Контактный телефон</label>
                    <input type="tel" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required placeholder="+7 (___) ___-__-__">
                </div>

                <div class="form-group">
                    <label>Желаемая дата доставки</label>
                    <input type="date" name="delivery_date" value="{{ old('delivery_date') }}" required min="{{ now()->addDay()->toDateString() }}">
                </div>

                <button type="submit" class="btn-submit">Подтвердить заказ</button>
            </form>
        </div>

        <div class="checkout-summary">
            <div class="summary-title">Ваш заказ</div>
            @foreach($items as $item)
                <div class="summary-item">
                    <span>{{ $item['car']->name }} × {{ $item['qty'] }}</span>
                    <span>{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</span>
                </div>
            @endforeach

            <div class="summary-divider"></div>
            <div class="summary-row"><span>Подытог</span><span>{{ number_format($total, 0, ',', ' ') }} ₽</span></div>
            @if($discount > 0)
                <div class="summary-row discount-row"><span>Скидка VIP</span><span>−{{ number_format($discount, 0, ',', ' ') }} ₽</span></div>
            @endif
            <div class="summary-total"><span>К оплате</span><span>{{ number_format($grandTotal, 0, ',', ' ') }} ₽</span></div>
        </div>
    </div>
</div>
@endsection