@extends('layouts.app')
@section('title', 'Бренды')
@section('content')
<div class="section">
    <div class="section-header" style="flex-direction:column; align-items:flex-start;">
        <div class="section-tag"> Бренды</div>
        <h1 class="section-title">Легендарные автомобильные марки</h1>
        <p class="section-sub">Изучите коллекции по производителю — от гиперкаров до люксовых внедорожников.</p>
    </div>

    @foreach($groups as $category => $brands)
        <div class="brand-category-block">
            <div class="brand-category-title">{{ $labels[$category] ?? $category }}</div>
            <div class="brands-grid">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand) }}" class="brand-tile">
                        <div class="brand-tile-name">{{ $brand->name }}</div>
                        <div class="brand-tile-count">{{ $brand->cars_count }} авто</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection