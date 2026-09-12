@extends('layouts.admin')
@section('page-title', ' Дашборд')
@section('content')

{{-- Stat cards --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg,#1e1e20,#252527); border:1px solid #2a2a2c;">
            <div class="inner">
                <h3 style="color:var(--gold);">{{ $stats['cars'] }}</h3>
                <p style="color:#8d8a86; font-size:0.82rem; letter-spacing:1px;">АВТОМОБИЛЕЙ</p>
            </div>
            <div class="icon"><i class="bi bi-car-front" style="color:rgba(201,168,106,0.15); font-size:3rem;"></i></div>
            <a href="{{ route('admin.cars.index') }}" class="small-box-footer" style="background:rgba(201,168,106,0.08); color:var(--gold);">
                Управление <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg,#1e1e20,#252527); border:1px solid #2a2a2c;">
            <div class="inner">
                <h3 style="color:var(--gold);">{{ $stats['customers'] }}</h3>
                <p style="color:#8d8a86; font-size:0.82rem; letter-spacing:1px;">КЛИЕНТОВ</p>
            </div>
            <div class="icon"><i class="bi bi-people" style="color:rgba(201,168,106,0.15); font-size:3rem;"></i></div>
            <a href="{{ route('admin.customers.index') }}" class="small-box-footer" style="background:rgba(201,168,106,0.08); color:var(--gold);">
                Управление <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg,#1e1e20,#252527); border:1px solid #2a2a2c;">
            <div class="inner">
                <h3 style="color:var(--gold);">{{ $stats['orders'] }}</h3>
                <p style="color:#8d8a86; font-size:0.82rem; letter-spacing:1px;">ЗАКАЗОВ</p>
            </div>
            <div class="icon"><i class="bi bi-bag-check" style="color:rgba(201,168,106,0.15); font-size:3rem;"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer" style="background:rgba(201,168,106,0.08); color:var(--gold);">
                Управление <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg,#1e1e20,#252527); border:1px solid #2a2a2c;">
            <div class="inner">
                <h3 style="color:var(--gold); font-size:1.4rem;">{{ number_format($stats['revenue'], 0, ',', ' ') }} ₽</h3>
                <p style="color:#8d8a86; font-size:0.82rem; letter-spacing:1px;">ВЫРУЧКА</p>
            </div>
            <div class="icon"><i class="bi bi-currency-dollar" style="color:rgba(201,168,106,0.15); font-size:3rem;"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer" style="background:rgba(201,168,106,0.08); color:var(--gold);">
                Все заказы <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    {{-- Revenue chart --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Выручка по месяцам</h3>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Status breakdown --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Заказы по статусу</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush" style="background:transparent;">
                    @foreach(\App\Models\Order::statusLabels() as $key => $label)
                        @php $count = $statusBreakdown[$key] ?? 0; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="background:transparent; border-color:#252527; color:#ece9e4; font-size:0.85rem;">
                            {{ $label }}
                            <span class="badge" style="background:rgba(201,168,106,0.15); color:var(--gold); border:1px solid rgba(201,168,106,0.3);">
                                {{ $count }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Top cars --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Топ автомобилей</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>#</th><th>Автомобиль</th><th>Бренд</th><th>Продаж</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topCars as $i => $car)
                            <tr>
                                <td style="color:var(--gold); font-weight:600;">{{ $i+1 }}</td>
                                <td>{{ $car->name }}</td>
                                <td style="color:#666;">{{ $car->brand->name ?? '' }}</td>
                                <td><span class="badge badge-secondary">{{ $car->order_items_count }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center" style="color:#555; padding:20px;">Продаж пока нет</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent orders --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Последние заказы</h3>
                <a href="{{ route('admin.orders.index') }}" style="color:var(--gold); font-size:0.78rem;">Все →</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>№</th><th>Клиент</th><th>Сумма</th><th>Статус</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td style="color:var(--gold);">#{{ $order->id }}</td>
                                <td>{{ $order->customer->name ?? '—' }}</td>
                                <td>{{ number_format($order->total, 0, ',', ' ') }} ₽</td>
                                <td><span class="badge badge-secondary" style="font-size:0.7rem;">{{ \App\Models\Order::statusLabels()[$order->status] ?? $order->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center" style="color:#555; padding:20px;">Заказов нет</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthly->keys()->map(fn($m) => \Carbon\Carbon::parse($m)->translatedFormat('M Y'))->values()) !!},
        datasets: [{
            label: 'Выручка (₽)',
            data: {!! json_encode($monthly->values()) !!},
            backgroundColor: 'rgba(201,168,106,0.3)',
            borderColor: 'rgba(201,168,106,0.8)',
            borderWidth: 1,
            borderRadius: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#8d8a86', font: { family: 'Poppins' } } }
        },
        scales: {
            x: { ticks: { color: '#555' }, grid: { color: '#1e1e20' } },
            y: { ticks: { color: '#555' }, grid: { color: '#1e1e20' } }
        }
    }
});
</script>
@endpush

@endsection