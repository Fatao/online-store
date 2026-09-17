@extends('layouts.admin')
@section('page-title', 'Заказ #' . $order->id)
@section('content')

<div class="order-detail-header">
    <a href="{{ route('admin.orders.index') }}" class="btn-ghost-sm">← Все заказы</a>
</div>

<div class="info-grid">
    <div class="info-box">
        <div class="info-label">Клиент: </div>
        <div class="info-value">{{ $order->customer->name ?? '—' }}</div>
        <div class="muted">{{ $order->customer->email ??  '' }}</div>
    </div>
    <div class="info-box">
        <div class="info-label">Дата заказа: </div>
        <div class="info-value">{{ $order->sale_date->format('d.m.Y') }}</div>
    </div>
    <div class="info-box">
        <div class="info-label">Дата доставки: </div>
        <div class="info-value">{{ $order->delivery_date?->format('d.m.Y') ?? '—' }}</div>
    </div>
</div>

<div class="info-grid">
    <div class="info-box">
        <div class="info-label">Адрес доставки: </div>
        <div class="info-value">{{ $order->shipping_address }}</div>
    </div>
    <div class="info-box">
        <div class="info-label">Телефон: </div>
        <div class="info-value">{{ $order->shipping_phone }}</div>
    </div>
    <div class="info-box">
        <div class="info-label">Текущий статус: </div>
        <div class="info-value"><span class="badge">{{ \App\Models\Order::statusLabels()[$order->status] ?? $order->status }}</span></div>
    </div>
</div>

<table class="data-table">
    <thead>
        <tr><th>Автомобиль</th><th>Бренд</th><th>Кол-во</th><th>Цена</th><th>Сумма</th></tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->car->name ?? 'Автомобиль удалён' }}</td>
                <td>{{ $item->car->brand->name ?? '—' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 0, ',', ' ') }} ₽</td>
                <td>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="status-update-box">
    <div class="form-section-title" style="margin-bottom:14px;">Обновить статус заказа</div>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="display:flex; gap:12px; align-items:flex-end;">
        @csrf @method('PUT')
        <div class="form-group" style="flex:1; margin-bottom:0;">
            <select name="status">
                @foreach(\App\Models\Order::statusLabels() as $key => $label)
                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary-sm">Сохранить</button>
    </form>
</div>

<div class="order-summary-box" style="margin-top:20px; max-width:340px;">
    <div class="meta-row"><span>Подытог</span><span>{{ number_format($order->subtotal, 0, ',', ' ') }} ₽</span></div>
    @if($order->discount > 0)
        <div class="meta-row"><span>Скидка</span><span class="accent">−{{ number_format($order->discount, 0, ',', ' ') }} ₽</span></div>
    @endif
    <div class="meta-row" style="font-weight:700;"><span>Итого</span><span class="accent">{{ number_format($order->total, 0, ',', ' ') }} ₽</span></div>
</div>

@endsection
