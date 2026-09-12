@extends('layouts.admin')
@section('page-title', 'Клиенты')
@section('content')

<table class="data-table">
    <thead>
        <tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Заказов</th><th>Потрачено</th><th>VIP</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? '—' }}</td>
                <td>{{ $customer->orders_count }}</td>
                <td>{{ number_format($customer->total_spent, 0, ',', ' ') }} ₽</td>
                <td>
                    <span class="status-dot-inline" style="background: {{ $customer->is_regular ? 'var(--gold)' : 'var(--border2)' }};"></span>
                    {{ $customer->is_regular ? 'Да' : 'Нет' }}
                </td>
                <td class="actions-cell">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn-outline-sm">Подробнее</a>
                    <form action="{{ route('admin.customers.toggleRegular', $customer) }}" method="POST">
                        @csrf @method('PUT')
                        <button type="submit" class="btn-ghost-sm">{{ $customer->is_regular ? 'Снять VIP' : 'Дать VIP' }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="empty-cell">Клиенты не найдены</td></tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrap">{{ $customers->links() }}</div>

@endsection
