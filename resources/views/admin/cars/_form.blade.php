@csrf
@if(isset($car)) @method('PUT') @endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="form-section-title">Основная информация</div>

<div class="form-row">
    <div class="form-group">
        <label>Бренд</label>
        <select name="brand_id" required>
            <option value="">— Выберите бренд —</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Модель</label>
        <input type="text" name="model" value="{{ old('model', $car->model ?? '') }}" required placeholder="488 Pista">
    </div>
</div>

<div class="form-group">
    <label>Полное название (отображается на сайте)</label>
    <input type="text" name="name" value="{{ old('name', $car->name ?? '') }}" required placeholder="Ferrari 488 Pista">
</div>

<div class="form-row">
    <div class="form-group">
        <label>Цена (₽)</label>
        <input type="number" name="price" value="{{ old('price', $car->price ?? '') }}" required min="0" step="0.01">
    </div>
    <div class="form-group">
        <label>Единица</label>
        <input type="text" name="unit" value="{{ old('unit', $car->unit ?? 'шт.') }}" placeholder="шт.">
    </div>
    <div class="form-group">
        <label>Год выпуска</label>
        <input type="number" name="year" value="{{ old('year', $car->year ?? '') }}" min="1950" max="{{ date('Y') + 1 }}">
    </div>
</div>

<div class="form-section-title">Технические характеристики</div>

<div class="form-row">
    <div class="form-group">
        <label>Пробег (км)</label>
        <input type="number" name="mileage" value="{{ old('mileage', $car->mileage ?? '') }}" min="0">
    </div>
    <div class="form-group">
        <label>Мощность (л.с.)</label>
        <input type="number" name="horsepower" value="{{ old('horsepower', $car->horsepower ?? '') }}" min="0">
    </div>
    <div class="form-group">
        <label>Цвет</label>
        <input type="text" name="color" value="{{ old('color', $car->color ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label>Тип топлива</label>
        <select name="fuel_type">
            <option value="">—</option>
            @foreach(['Бензин','Дизель','Гибрид','Электро'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type', $car->fuel_type ?? '') == $f ? 'selected' : '' }}>{{ $f }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Трансмиссия</label>
        <select name="transmission">
            <option value="">—</option>
            @foreach(['Автомат','Механика'] as $t)
                <option value="{{ $t }}" {{ old('transmission', $car->transmission ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Тип кузова</label>
        <select name="body_type">
            <option value="">—</option>
            @foreach(['Седан','Купе','Внедорожник','Кабриолет','Хэтчбек'] as $b)
                <option value="{{ $b }}" {{ old('body_type', $car->body_type ?? '') == $b ? 'selected' : '' }}>{{ $b }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-section-title">Описание</div>

<div class="form-group">
    <label>Описание</label>
    <textarea name="description">{{ old('description', $car->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Особенности (через запятую)</label>
    <input type="text" name="features" value="{{ old('features', $car->features ?? '') }}" placeholder="Кожаный салон, Климат-контроль, Навигация">
</div>

<div class="form-section-title">Изображение</div>

<div class="form-group">
    <label>Главное фото</label>
    <input type="file" name="image" accept="image/*">
    @if(isset($car) && $car->image)
        <img src="{{ asset('storage/' . $car->image) }}" class="table-thumb" style="margin-top:10px; width:80px; height:80px;">
        <span class="form-hint">Загрузите новое фото, чтобы заменить текущее.</span>
    @endif
</div>

<div class="form-section-title">Наличие</div>

<div class="form-row">
    <div class="form-group">
        <label>Количество на складе</label>
        <input type="number" name="stock" value="{{ old('stock', $car->stock ?? 1) }}" min="0">
    </div>
</div>

<div class="form-check">
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $car->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active">Показывать на сайте</label>
</div>

<div class="form-check">
    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $car->is_featured ?? false) ? 'checked' : '' }}>
    <label for="is_featured">Показывать на главной странице (избранное)</label>
</div>

<div class="form-actions">
    <button type="submit" class="btn-primary-sm">{{ isset($car) ? 'Сохранить изменения' : 'Добавить автомобиль' }}</button>
    <a href="{{ route('admin.cars.index') }}" class="btn-ghost-sm">Отмена</a>
</div>