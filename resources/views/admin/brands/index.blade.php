@extends('layouts.admin')
@section('page-title', 'Бренды')
@section('content')

<div class="admin-section-header">
    <a href="{{ route('admin.brands.create') }}" class="btn-primary-sm">+ Добавить бренд</a>
</div>

<table class="data-table">
    <thead>
        <tr><th>Лого</th><th>Название</th><th>Категория</th><th>Автомобилей</th><th>На главной</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($brands as $brand)
            <tr>
                <td>
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" class="table-thumb">
                    @else
                        <div class="table-thumb-empty">🏷</div>
                    @endif
                </td>
                <td>{{ $brand->name }}</td>
                <td><span class="badge">{{ \App\Models\Brand::categoryLabels()[$brand->category] ?? $brand->category }}</span></td>
                <td>{{ $brand->cars_count }}</td>
                <td>{{ $brand->featured ? 'Да' : 'Нет' }}</td>
                <td class="actions-cell">
                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn-outline-sm">Изменить</a>
                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Удалить бренд? Связанные автомобили также будут удалены.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-sm">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty-cell">Бренды не найдены</td></tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrap">{{ $brands->links() }}</div>

@endsection