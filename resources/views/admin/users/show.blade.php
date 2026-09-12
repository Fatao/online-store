@extends('layouts.admin')
@section('title', 'Клиент: ' . $customer->name)

@section('content')

<div class="dash-card" style="max-width:860px;margin-bottom:16px">

    <div class="order-detail-header">
        <div>
            <div class="muted" style="font-size:11px;letter-spacing:2px;margin-bottom:4px">КЛИЕНТ #{{ $customer->id }}</div>
            <h2 style="font-size:1.3rem;color:#fff">{{ $customer->name }}</h2>
        </div>
        @if($customer->is_regular)
            <span class="badge-regular" style="font-size:0.85rem;padding:5px 14px">★ Постоянный клиент</span>
        @endif
    </div>

    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">КОНТАКТЫ</div>
            <div class="info-value">{{ $customer->email }}</div>
            <div class="muted">{{ $customer->phone ?? '—' }}</div>
        </div>
        <div class="info-box">
            <div class="info-label">ФИНАНСЫ</div>
            <div class="info-value accent" style="color:var(--accent)">
                {{ number_format($customer->total_spent, 0, ',', ' ') }} ₽
            </div>
            <div class="muted">Всего потрачено</div>
        </div>
        <div class="info-box">
            <div class="info-label">АДРЕС</div>
            <div class="info-value" style="font-size:0.85rem">{{ $customer->address ?? '—' }}</div>
        </div>
    </div>

    {{-- Toggle regular status --}}
    <form action="{{ route('admin.customers.toggleRegular', $customer) }}" method="POST"
          style="margin-top:12px">
        @csrf @method('PUT')
        <button type="submit" class="{{ $customer->is_regular ? 'btn-danger-sm' : 'btn-outline-sm' }}">
            {{ $customer->is_regular ? '✕ Снять статус постоянного' : '★ Сделать постоянным клиентом' }}
        </button>
    </form>

</div>

{{-- Order history --}}
<div class="dash-card" style="max-width:860px">
    <div class="dash-card-title"> ИСТОРИЯ ЗАКАЗОВ ({{ $customer->orders->count() }})</div>

    @if($customer->orders->isEmpty())
        <p class="muted">Заказов нет.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Товаров</th>
                    <th>Сумма</th>
                    <th>Скидка</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->orders as $order)
                    <tr>
                        <td class="muted">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="accent">{{ number_format($order->total, 0, ',', ' ') }} ₽</td>
                        <td class="muted">
                            {{ $order->discount > 0 ? '−'.number_format($order->discount,0,',', ' ').' ₽' : '—' }}
                        </td>
                        <td style="color:{{ $order->statusColor() }}">{{ $order->statusLabel() }}</td>
                        <td class="muted">{{ $order->created_at->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-outline-sm">→</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<a href="{{ route('admin.customers.index') }}" class="btn-ghost"
   style="margin-top:12px;display:inline-block">← Назад к клиентам</a>

@endsection
