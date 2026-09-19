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
                <label>ИМЯ</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Ваше имя" required autofocus>
            </div>

            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label>ТЕЛЕФОН <span class="muted">(необязательно)</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="+7 (999) 000-00-00">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>ПАРОЛЬ</label>
                    <input type="password" name="password"
                           placeholder="Мин. 6 символов" required>
                </div>
                <div class="form-group">
                    <label>ПОВТОР ПАРОЛЯ</label>
                    <input type="password" name="password_confirmation"
                           placeholder="Повторите пароль" required>
                </div>
            </div>

            {{-- Math Captcha --}}
            <div class="form-group">
                <label>КОД ПОДТВЕРЖДЕНИЯ</label>
                <div style="background:rgba(201,168,106,0.06);border:1px solid rgba(201,168,106,0.2);border-radius:4px;padding:14px 18px;margin-bottom:10px;display:flex;align-items:center;gap:14px;">
                    <span id="captcha-question"
                          style="font-family:monospace;font-size:1.3rem;color:#c9a86a;letter-spacing:2px;font-weight:700;">
                        Загрузка...
                    </span>
                    <button type="button" onclick="loadCaptcha()"
                            style="background:transparent;border:1px solid rgba(201,168,106,0.3);color:#c9a86a;border-radius:3px;padding:4px 10px;cursor:pointer;font-size:0.8rem;">
                        ↻ Обновить
                    </button>
                </div>
                <input type="number" name="captcha"
                       placeholder="Введите ответ" autocomplete="off"
                       value="{{ old('captcha') }}" required>
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

@push('scripts')
<script>
function loadCaptcha() {
    fetch('/captcha')
        .then(r => r.json())
        .then(data => {
            document.getElementById('captcha-question').textContent = data.question;
        });
}
// Load on page open
loadCaptcha();
</script>
@endpush

@endsection