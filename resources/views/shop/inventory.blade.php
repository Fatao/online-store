@extends('layouts.app')
@section('title', 'Каталог')
@section('content')
<div class="catalog-wrap">

    <div class="catalog-header">
        <div>
            <div class="section-tag">// Каталог</div>
            <h1 class="page-title" style="margin-bottom:0;">Автомобили</h1>
        </div>
        <form action="{{ route('inventory.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Поиск по модели..." value="{{ request('search') }}">
            @foreach(request()->except(['search','page']) as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <button type="submit">Найти</button>
        </form>
    </div>

    <form action="{{ route('inventory.index') }}" method="GET" id="filter-form" class="filters-panel">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

        <div class="filters-grid">

            {{-- BRAND: counts = cars matching all OTHER active filters --}}
            <div class="form-group" style="margin-bottom:0;">
                <label>Бренд</label>
                <select name="brand" onchange="this.form.submit()">
                    <option value="">Все бренды</option>
                    @foreach($brands as $brand)
                        @php $isSelected = request('brand') == $brand->id; $cnt = $brandCounts[$brand->id] ?? 0; @endphp
                        <option value="{{ $brand->id }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $brand->name }}@if(!$isSelected) ({{ $cnt }})@endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FUEL TYPE: counts based on all other active filters --}}
            <div class="form-group" style="margin-bottom:0;">
                <label>Тип топлива</label>
                <select name="fuel_type" onchange="this.form.submit()">
                    <option value="">Любой</option>
                    @foreach(['Бензин','Дизель','Гибрид','Электро'] as $f)
                        @php $isSelected = request('fuel_type') == $f; $cnt = $fuelCounts[$f] ?? 0; @endphp
                        <option value="{{ $f }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $f }}@if(!$isSelected) ({{ $cnt }})@endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TRANSMISSION: counts based on all other active filters --}}
            <div class="form-group" style="margin-bottom:0;">
                <label>Трансмиссия</label>
                <select name="transmission" onchange="this.form.submit()">
                    <option value="">Любая</option>
                    @foreach(['Автомат','Механика'] as $t)
                        @php $isSelected = request('transmission') == $t; $cnt = $transmissionCounts[$t] ?? 0; @endphp
                        <option value="{{ $t }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $t }}@if(!$isSelected) ({{ $cnt }})@endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BODY TYPE: counts based on all other active filters --}}
            <div class="form-group" style="margin-bottom:0;">
                <label>Тип кузова</label>
                <select name="body_type" onchange="this.form.submit()">
                    <option value="">Любой</option>
                    @foreach(['Седан','Купе','Внедорожник','Кабриолет','Хэтчбек'] as $b)
                        @php $isSelected = request('body_type') == $b; $cnt = $bodyCounts[$b] ?? 0; @endphp
                        <option value="{{ $b }}" {{ $isSelected ? 'selected' : '' }}>
                            {{ $b }}@if(!$isSelected) ({{ $cnt }})@endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Цена от (₽)</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Цена до (₽)</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="∞" min="0">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Сортировка</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="">Новые первыми</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Цена ↑</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
                </select>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:12px;margin-top:14px;flex-wrap:wrap;">
            <button type="submit" class="btn-outline-sm">Применить фильтры</button>
            <a href="{{ route('inventory.index') }}" class="btn-ghost-sm">Сбросить</a>
        </div>
    </form>

    {{-- Results counter --}}
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:0.9rem;color:#ece9e4;">
            Найдено: <strong style="color:#c9a86a;font-family:monospace;font-size:1.1rem;">{{ $cars->total() }}</strong>
            @if($cars->total() % 10 == 1 && $cars->total() % 100 != 11) автомобиль
            @elseif($cars->total() % 10 >= 2 && $cars->total() % 10 <= 4 && ($cars->total() % 100 < 10 || $cars->total() % 100 >= 20)) автомобиля
            @else автомобилей @endif
        </span>

        {{-- Active filter badges with ✕ to remove one filter at a time --}}
        @if(request('brand'))
            @php $b = $brands->firstWhere('id', request('brand')); @endphp
            <span style="background:rgba(201,168,106,0.12);color:#c9a86a;padding:3px 10px;border-radius:12px;font-size:0.76rem;border:1px solid rgba(201,168,106,0.3);">
                {{ $b->name ?? '' }}
                <a href="{{ route('inventory.index', array_merge(request()->except(['brand','page']))) }}" style="color:#c9a86a;margin-left:4px;text-decoration:none;">✕</a>
            </span>
        @endif
        @if(request('transmission'))
            <span style="background:rgba(201,168,106,0.12);color:#c9a86a;padding:3px 10px;border-radius:12px;font-size:0.76rem;border:1px solid rgba(201,168,106,0.3);">
                {{ request('transmission') }}
                <a href="{{ route('inventory.index', array_merge(request()->except(['transmission','page']))) }}" style="color:#c9a86a;margin-left:4px;text-decoration:none;">✕</a>
            </span>
        @endif
        @if(request('fuel_type'))
            <span style="background:rgba(201,168,106,0.12);color:#c9a86a;padding:3px 10px;border-radius:12px;font-size:0.76rem;border:1px solid rgba(201,168,106,0.3);">
                {{ request('fuel_type') }}
                <a href="{{ route('inventory.index', array_merge(request()->except(['fuel_type','page']))) }}" style="color:#c9a86a;margin-left:4px;text-decoration:none;">✕</a>
            </span>
        @endif
        @if(request('body_type'))
            <span style="background:rgba(201,168,106,0.12);color:#c9a86a;padding:3px 10px;border-radius:12px;font-size:0.76rem;border:1px solid rgba(201,168,106,0.3);">
                {{ request('body_type') }}
                <a href="{{ route('inventory.index', array_merge(request()->except(['body_type','page']))) }}" style="color:#c9a86a;margin-left:4px;text-decoration:none;">✕</a>
            </span>
        @endif
        @if(request('search'))
            <span style="background:rgba(201,168,106,0.12);color:#c9a86a;padding:3px 10px;border-radius:12px;font-size:0.76rem;border:1px solid rgba(201,168,106,0.3);">
                "{{ request('search') }}"
                <a href="{{ route('inventory.index', array_merge(request()->except(['search','page']))) }}" style="color:#c9a86a;margin-left:4px;text-decoration:none;">✕</a>
            </span>
        @endif
    </div>

    @if($cars->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🚗</div>
            <p>По заданным критериям автомобили не найдены.</p>
            <a href="{{ route('inventory.index') }}" class="btn-outline-sm">Сбросить фильтры</a>
        </div>
    @else
        <div class="cars-grid">
            @foreach($cars as $car)
                @include('shop._car_card', ['car' => $car])
            @endforeach
        </div>
        <div class="pagination-wrap">{{ $cars->links() }}</div>
    @endif

</div>
@endsection