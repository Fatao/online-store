@extends('layouts.admin')
@section('page-title', 'Заказы')
@section('content')

<div class="filter-tabs">
    <a href="{{ route('admin.orders.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">Все</a>
    @foreach(\App\Models\Order::statusLabels() as $key => $label)
        <a href="{{ route('admin.orders.index', ['status' => $key]) }}" class="filter-tab {{ request('status') == $key ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
</div>

<table class="data-table">
    <thead>
        <tr><th>№</th><th>Клиент</th><th>Сумма</th><th>Дата заказа</th><th>Доставка</th><th>Статус</th><th></th></tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td class="order-id">#{{ $order->id }}</td>
                <td>{{ $order->customer->name ?? '—' }}</td>
                <td>{{ number_format($order->total, 0, ',', ' ') }} ₽</td>
                <td>{{ $order->sale_date->format('d.m.Y') }}</td>
                <td>{{ $order->delivery_date?->format('d.m.Y') ?? '—' }}</td>
                <td><span class="badge">{{ \App\Models\Order::statusLabels()[$order->status] ?? $order->status }}</span></td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn-outline-sm">Подробнее</a></td>
            </tr>
        @empty
            <tr><td colspan="7" class="empty-cell">Заказов нет</td></tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrap">{{ $orders->links() }}</div>

@endsection