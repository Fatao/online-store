@extends('layouts.app')
@section('title', 'Финансирование')
@section('content')
<div class="finance-wrap">
    <div class="section-tag"> Финансирование </div>
    <h1 class="page-title">Калькулятор финансирования</h1>
    <p class="muted" style="margin-bottom:28px;">Рассчитайте ежемесячный платёж исходя из стоимости автомобиля, первоначального взноса и срока.</p>

    <form action="{{ route('finance.calculate') }}" method="POST" class="glass" style="padding:30px;">
        @csrf

        <div class="form-group">
            <label>Выберите автомобиль (необязательно)</label>
            <select name="car_select" id="car_select" onchange="document.getElementById('price_input').value = this.options[this.selectedIndex].dataset.price || ''">
                <option value="">— Указать стоимость вручную —</option>
                @foreach($cars as $c)
                    <option value="{{ $c->id }}" data-price="{{ $c->price }}" {{ request('car_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} — {{ number_format($c->price, 0, ',', ' ') }} ₽
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Стоимость автомобиля (₽)</label>
                <input type="number" id="price_input" name="price" value="{{ old('price', $result['price'] ?? '') }}" required min="0" step="0.01">
            </div>
            <div class="form-group">
                <label>Первоначальный взнос (₽)</label>
                <input type="number" name="down_payment" value="{{ old('down_payment', $result['down_payment'] ?? 0) }}" min="0" step="0.01">
            </div>
            <div class="form-group">
                <label>Срок (месяцев)</label>
                <input type="number" name="months" value="{{ old('months', $result['months'] ?? 12) }}" required min="1" max="120">
            </div>
        </div>

        <button type="submit" class="btn-submit">Рассчитать</button>
    </form>

    @if($result)
        <div class="finance-result">
            <div class="finance-result-row">
                <span>Стоимость автомобиля</span>
                <span>{{ number_format($result['price'], 0, ',', ' ') }} ₽</span>
            </div>
            <div class="finance-result-row">
                <span>Первоначальный взнос</span>
                <span>{{ number_format($result['down_payment'], 0, ',', ' ') }} ₽</span>
            </div>
            <div class="finance-result-row">
                <span>Сумма к финансированию</span>
                <span>{{ number_format($result['financed_amount'], 0, ',', ' ') }} ₽</span>
            </div>
            <div class="finance-result-row">
                <span>Срок</span>
                <span>{{ $result['months'] }} мес.</span>
            </div>
            <div class="finance-result-row">
                <span>Ежемесячный платёж</span>
                <span>{{ number_format($result['monthly_payment'], 2, ',', ' ') }} ₽</span>
            </div>
        </div>
        <p class="form-hint" style="margin-top:14px;">Расчёт приведён без учёта процентной ставки и является ориентировочным.</p>
    @endif
</div>
@endsection