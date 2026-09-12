@extends('layouts.app')
@section('title', 'Вход')
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <h1> ВХОД </h1>
            <p>Введите данные вашего аккаунта</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="you@example.com"
                       required autofocus>
            </div>

            <div class="form-group">
                <label for="password">ПАРОЛЬ</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••"
                       required>
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="text-transform:none;letter-spacing:0;font-size:0.85rem;">
                    Запомнить меня
                </label>
            </div>

            <button type="submit" class="btn-submit">ВОЙТИ</button>
        </form>

        <div class="auth-footer">
            Нет аккаунта?
            <a href="{{ route('register') }}">Зарегистрироваться</a>
        </div>
    </div>
</div>
@endsection