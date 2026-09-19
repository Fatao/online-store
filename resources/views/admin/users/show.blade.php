@extends('layouts.admin')
@section('page-title', 'Клиент: ' . $customer->name)
@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h2 style="color:#c9a86a;font-family:'Cinzel',serif;font-size:1.1rem;">{{ $customer->name }}</h2>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-outline-secondary">← Все клиенты</a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="info-label">Email</div>
                <div style="color:#ece9e4;font-weight:500;margin-bottom:12px;">{{ $customer->email }}</div>
                <div class="info-label">Телефон</div>
                <div style="color:#ece9e4;margin-bottom:12px;">{{ $customer->phone ?? '—' }}</div>
                <div class="info-label">Адрес</div>
                <div style="color:#ece9e4;margin-bottom:12px;">{{ $customer->address ?? '—' }}</div>
                <div class="info-label">Потрачено всего</div>
                <div style="color:#c9a86a;font-family:monospace;font-size:1.1rem;margin-bottom:12px;">{{ number_format($customer->total_spent,0,',', ' ') }} ₽</div>
                <div class="info-label">Статус VIP</div>
                <div style="color:{{ $customer->is_regular ? '#c9a86a' : '#555' }};">
                    {{ $customer->is_regular ? '★ VIP-клиент (скидка 2%)' : 'Обычный клиент' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title mb-0">История заказов</h3></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>№</th><th>Дата</th><th>Сумма</th><th>Скидка</th><th>Статус</th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                            <tr>
                                <td style="color:#c9a86a;font-family:monospace;">#{{ $order->id }}</td>
                                <td style="color:#ece9e4;">{{ $order->sale_date->format('d.m.Y') }}</td>
                                <td style="color:#c9a86a;font-family:monospace;">{{ number_format($order->total,0,',', ' ') }} ₽</td>
                                <td style="color:#8d8a86;">{{ $order->discount > 0 ? '−'.number_format($order->discount,0,',',' ').' ₽' : '—' }}</td>
                                <td><span style="color:{{ $order->statusColor() }};font-size:0.82rem;">{{ $order->statusLabel() }}</span></td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">→</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;padding:28px;color:#555;">Заказов нет</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection