@extends('layouts.app')
@section('title', 'Каталог')
@section('content')
<div class="catalog-wrap">

    <div class="catalog-header">
        <h1 class="page-title"> Каталог автомобилей</h1>
        <form action="{{ route('inventory.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Поиск по модели..." value="{{ request('search') }}">
            <button type="submit">Найти</button>
        </form>
    </div>

    <form action="{{ route('inventory.index') }}" method="GET" class="filters-panel">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

        <div class="filters-grid">
            <div class="form-group" style="margin-bottom:0;">
                <label>Бренд</label>
                <select name="brand" onchange="this.form.submit()">
                    <option value="">Все бренды</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }} ({{ $brand->cars_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Тип топлива</label>
                <select name="fuel_type" onchange="this.form.submit()">
                    <option value="">Любой</option>
                    @foreach(['Бензин','Дизель','Гибрид','Электро'] as $f)
                        <option value="{{ $f }}" {{ request('fuel_type') == $f ? 'selected' : '' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Трансмиссия</label>
                <select name="transmission" onchange="this.form.submit()">
                    <option value="">Любая</option>
                    @foreach(['Автомат','Механика'] as $t)
                        <option value="{{ $t }}" {{ request('transmission') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Тип кузова</label>
                <select name="body_type" onchange="this.form.submit()">
                    <option value="">Любой</option>
                    @foreach(['Седан','Купе','Внедорожник','Кабриолет','Хэтчбек'] as $b)
                        <option value="{{ $b }}" {{ request('body_type') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Цена от</label>
                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Цена до</label>
                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="∞">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label>Сортировка</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="">Новые первыми</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn-outline-sm">Применить фильтры</button>
        <a href="{{ route('inventory.index') }}" class="btn-ghost-sm" style="margin-left:8px;">Сбросить</a>
    </form>

    <div class="results-count">Найдено: {{ $cars->total() }} автомобилей</div>

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

        <div class="pagination-wrap">
            {{ $cars->links() }}
        </div>
    @endif

</div>
@endsection