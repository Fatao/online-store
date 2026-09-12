@extends('layouts.app')
@section('title', 'Мои заказы')
@section('content')
<div class="orders-wrap">
    <h1 class="page-title"> Мои заказы</h1>

    @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <p>У вас пока нет заказов.</p>
            <a href="{{ route('inventory.index') }}" class="btn-outline-sm">Перейти в каталог</a>
        </div>
    @else
        <div class="orders-list">
            <div class="order-row" style="font-weight:600; color: var(--muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:1px;">
                <span>№</span><span>Дата</span><span>Сумма</span><span>Доставка</span><span>Статус</span><span></span>
            </div>
            @foreach($orders as $order)
                <div class="order-row">
                    <span class="order-id">#{{ $order->id }}</span>
                    <span>{{ $order->sale_date->format('d.m.Y') }}</span>
                    <span>{{ number_format($order->total, 0, ',', ' ') }} ₽</span>
                    <span>{{ $order->delivery_date?->format('d.m.Y') ?? '—' }}</span>
                    <span class="badge">{{ \App\Models\Order::statusLabels()[$order->status] ?? $order->status }}</span>
                    <a href="{{ route('orders.show', $order) }}" class="btn-ghost-sm">Подробнее</a>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrap">{{ $orders->links() }}</div>
    @endif
</div>
@endsection