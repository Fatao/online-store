@extends('layouts.app')
@section('title', 'Регистрация')
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <h1> РЕГИСТРАЦИЯ</h1>
            <p>Создайте новый аккаунт</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">ИМЯ</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Ваше имя"
                       required autofocus>
            </div>

            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="you@example.com"
                       required>
            </div>

            <div class="form-group">
                <label for="phone">ТЕЛЕФОН <span class="muted">(необязательно)</span></label>
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="+7 (999) 000-00-00">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">ПАРОЛЬ</label>
                    <input type="password" id="password" name="password"
                           placeholder="Мин. 6 символов"
                           required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">ПОВТОР ПАРОЛЯ</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Повторите пароль"
                           required>
                </div>
            </div>

            {{-- Captcha --}}
            <div class="form-group">
                <label>КОД С КАРТИНКИ</label>
                <div class="captcha-row">
                    <img src="{{ route('captcha') }}" alt="captcha" class="captcha-img" id="captcha-img">
                    <button type="button" class="captcha-refresh" onclick="
                        document.getElementById('captcha-img').src='{{ route('captcha') }}?'+Date.now()
                    " title="Обновить">↻</button>
                </div>
                <input type="text" name="captcha"
                       placeholder="Введите символы с картинки"
                       autocomplete="off"
                       value="{{ old('captcha') }}">
                @error('captcha')
                    <span class="form-hint danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">СОЗДАТЬ АККАУНТ</button>
        </form>

        <div class="auth-footer">
            Уже есть аккаунт?
            <a href="{{ route('login') }}">Войти</a>
        </div>
    </div>
</div>
@endsection