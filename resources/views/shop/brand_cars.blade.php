@extends('layouts.app')
@section('title', $brand->name)
@section('content')
<div class="catalog-wrap">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Главная</a> 
        <a href="{{ route('brands.index') }}">Бренды</a> 
        {{ $brand->name }}
    </div>

    <h1 class="page-title"> {{ $brand->name }}</h1>
    <div class="results-count">Найдено: {{ $cars->total() }} автомобилей</div>

    @if($cars->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🚗</div>
            <p>Автомобили данного бренда пока не добавлены.</p>
            <a href="{{ route('inventory.index') }}" class="btn-outline-sm">Смотреть весь каталог</a>
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