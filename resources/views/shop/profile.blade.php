@extends('layouts.app')
@section('title', 'Мой профиль')
@section('content')
<div style="max-width:680px;margin:48px auto;padding:0 24px;">
    <div class="section-tag">// Аккаунт</div>
    <h1 class="page-title">Мой профиль</h1>

    @if(session('success'))
        <div class="flash flash-success" style="margin-bottom:20px;border-radius:4px;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <div class="glass" style="padding:32px;">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Телефон</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+7 (999) 000-00-00">
            </div>
            <div class="form-group">
                <label>Адрес доставки</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Город, улица, дом">
            </div>

            <div style="border-top:1px solid var(--border);margin:20px 0;padding-top:20px;">
                <div class="form-section-title">Сменить пароль (оставьте пустым, чтобы не менять)</div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Новый пароль</label>
                        <input type="password" name="password" placeholder="Мин. 6 символов">
                    </div>
                    <div class="form-group">
                        <label>Повтор пароля</label>
                        <input type="password" name="password_confirmation" placeholder="Повторите">
                    </div>
                </div>
            </div>

            <div style="background:rgba(201,168,106,0.06);border:1px solid rgba(201,168,106,0.2);border-radius:4px;padding:14px 18px;margin-bottom:20px;">
                <div style="font-size:0.78rem;color:#8d8a86;margin-bottom:4px;">Статус аккаунта</div>
                @if($user->is_regular)
                    <div style="color:#c9a86a;font-weight:600;">★ VIP-клиент — скидка 2% на все покупки</div>
                @else
                    @php $remaining = max(0, 5000 - $user->total_spent); @endphp
                    <div style="color:#8d8a86;font-size:0.88rem;">
                        До VIP-статуса осталось потратить:
                        <strong style="color:#ece9e4;">{{ number_format($remaining,0,',',' ') }} ₽</strong>
                    </div>
                @endif
                <div style="color:#555;font-size:0.78rem;margin-top:4px;">Всего потрачено: {{ number_format($user->total_spent,0,',',' ') }} ₽</div>
            </div>

            <button type="submit" class="btn-submit">Сохранить изменения</button>
        </form>
    </div>
</div>
@endsection