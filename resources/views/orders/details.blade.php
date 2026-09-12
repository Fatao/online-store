@extends('layouts.app')
@section('title', 'Заказ #' . $order->id)
@section('content')
<div class="order-detail-wrap">
    <div class="page-header">
        <h1 class="page-title" style="margin-bottom:0;"> Заказ #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn-ghost-sm">← Все заказы</a>
    </div>

    <div class="order-detail-layout">
        <div class="order-items-table">
            <div class="table-title">Состав заказа</div>
            <table class="data-table">
                <thead>
                    <tr><th>Автомобиль</th><th>Кол-во</th><th>Цена</th><th>Сумма</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->car->name ?? 'Автомобиль удалён' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 0, ',', ' ') }} ₽</td>
                            <td>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="order-summary-box">
            <div class="meta-row"><span>Статус</span><span class="badge">{{ \App\Models\Order::statusLabels()[$order->status] ?? $order->status }}</span></div>
            <div class="meta-row"><span>Дата заказа</span><span>{{ $order->sale_date->format('d.m.Y') }}</span></div>
            <div class="meta-row"><span>Дата доставки</span><span>{{ $order->delivery_date?->format('d.m.Y') ?? '—' }}</span></div>
            <div class="meta-row"><span>Адрес</span><span>{{ $order->shipping_address }}</span></div>
            <div class="meta-row"><span>Телефон</span><span>{{ $order->shipping_phone }}</span></div>
            <div class="meta-row"><span>Подытог</span><span>{{ number_format($order->subtotal, 0, ',', ' ') }} ₽</span></div>
            @if($order->discount > 0)
                <div class="meta-row"><span>Скидка</span><span class="accent">−{{ number_format($order->discount, 0, ',', ' ') }} ₽</span></div>
            @endif
            <div class="meta-row" style="font-weight:700;"><span>Итого</span><span class="accent">{{ number_format($order->total, 0, ',', ' ') }} ₽</span></div>
        </div>
    </div>
</div>
@endsection