@extends('layouts.admin')
@section('page-title', ' Автомобили')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Список автомобилей</h3>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-gold">
            + Добавить автомобиль
        </a>
    </div>
    <div class="card-body border-bottom" style="padding:12px 20px;">
        <form action="{{ route('admin.cars.index') }}" method="GET" class="d-flex gap-2" style="gap:8px;">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Поиск по названию..."
                   class="form-control form-control-sm" style="max-width:280px;">
            <button type="submit" class="btn btn-sm btn-outline-secondary">Найти</button>
            @if(request('search'))
                <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-outline-secondary">Сбросить</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0" style="table-layout:fixed;">
            <thead>
                <tr>
                    <th style="width:70px;">Фото</th>
                    <th>Название</th>
                    <th style="width:130px;">Бренд</th>
                    <th style="width:140px;">Цена</th>
                    <th style="width:70px;">Год</th>
                    <th style="width:100px;">Статус</th>
                    <th style="width:160px;">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars as $car)
                    <tr style="vertical-align:middle;">
                        <td>
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}"
                                     style="width:52px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #2a2a2c;">
                            @else
                                <div style="width:52px;height:40px;background:#1e1e20;border-radius:4px;border:1px solid #2a2a2c;display:flex;align-items:center;justify-content:center;font-size:1.1rem;">🚗</div>
                            @endif
                        </td>
                        <td style="color:#ece9e4; font-weight:500;">{{ $car->name }}</td>
                        <td style="color:#8d8a86;">{{ $car->brand->name ?? '—' }}</td>
                        <td style="color:#c9a86a; font-family:monospace;">{{ number_format($car->price, 0, ',', ' ') }} ₽</td>
                        <td style="color:#ece9e4;">{{ $car->year ?? '—' }}</td>
                        <td>
                            @if($car->is_active)
                                <span class="badge" style="background:rgba(201,168,106,0.15);color:#c9a86a;border:1px solid rgba(201,168,106,0.3);padding:4px 8px;">Активен</span>
                            @else
                                <span class="badge" style="background:rgba(226,86,107,0.15);color:#e2566b;border:1px solid rgba(226,86,107,0.3);padding:4px 8px;">Скрыт</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.cars.edit', $car) }}"
                               class="btn btn-sm btn-outline-secondary mr-1">Изменить</a>
                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirm('Удалить автомобиль?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                        style="background:transparent;border:1px solid #e2566b;color:#e2566b;">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:#555;">Автомобили не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cars->hasPages())
        <div class="card-footer" style="background:#1a1a1c;border-top:1px solid #252527;">
            {{ $cars->links() }}
        </div>
    @endif
</div>

@endsection