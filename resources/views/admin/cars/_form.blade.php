@csrf
@if(isset($car)) @method('PUT') @endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

<div class="form-section-title">Основная информация</div>

<div class="form-row">
    <div class="form-group col">
        <label>Бренд</label>
        <select name="brand_id" class="form-control" required>
            <option value="">— Выберите бренд —</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col">
        <label>Модель</label>
        <input type="text" name="model" class="form-control" value="{{ old('model', $car->model ?? '') }}" required placeholder="488 Pista">
    </div>
</div>

<div class="form-group">
    <label>Полное название (отображается на сайте)</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $car->name ?? '') }}" required placeholder="Ferrari 488 Pista">
</div>

<div class="form-row">
    <div class="form-group col">
        <label>Цена (₽)</label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $car->price ?? '') }}" required min="0" step="0.01">
    </div>
    <div class="form-group col">
        <label>Единица</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $car->unit ?? 'шт.') }}" placeholder="шт.">
    </div>
    <div class="form-group col">
        <label>Год выпуска</label>
        <input type="number" name="year" class="form-control" value="{{ old('year', $car->year ?? '') }}" min="1950" max="{{ date('Y') + 1 }}">
    </div>
</div>

<div class="form-section-title">Технические характеристики</div>

<div class="form-row">
    <div class="form-group col">
        <label>Пробег (км)</label>
        <input type="number" name="mileage" class="form-control" value="{{ old('mileage', $car->mileage ?? '') }}" min="0">
    </div>
    <div class="form-group col">
        <label>Мощность (л.с.)</label>
        <input type="number" name="horsepower" class="form-control" value="{{ old('horsepower', $car->horsepower ?? '') }}" min="0">
    </div>
    <div class="form-group col">
        <label>Цвет</label>
        <input type="text" name="color" class="form-control" value="{{ old('color', $car->color ?? '') }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col">
        <label>Тип топлива</label>
        <select name="fuel_type" class="form-control">
            <option value="">—</option>
            @foreach(['Бензин','Дизель','Гибрид','Электро'] as $f)
                <option value="{{ $f }}" {{ old('fuel_type', $car->fuel_type ?? '') == $f ? 'selected' : '' }}>{{ $f }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col">
        <label>Трансмиссия</label>
        <select name="transmission" class="form-control">
            <option value="">—</option>
            @foreach(['Автомат','Механика'] as $t)
                <option value="{{ $t }}" {{ old('transmission', $car->transmission ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col">
        <label>Тип кузова</label>
        <select name="body_type" class="form-control">
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
    <textarea name="description" class="form-control" rows="3">{{ old('description', $car->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Особенности (через запятую)</label>
    <input type="text" name="features" class="form-control" value="{{ old('features', $car->features ?? '') }}" placeholder="Кожаный салон, Климат-контроль, Навигация">
</div>

<div class="form-section-title">Изображения</div>

<div class="form-row">
    <div class="form-group col">
        <label>Главное фото</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        @if(isset($car) && $car->image)
            <div style="margin-top:10px;">
                <img src="{{ asset('files/' . $car->image) }}"
                     style="width:120px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #2a2a2c;"
                     onerror="this.style.display='none'">
                <div class="form-hint" style="margin-top:4px;">Загрузите новое, чтобы заменить.</div>
            </div>
        @endif
    </div>
    <div class="form-group col">
        <label>Галерея (можно выбрать несколько)</label>
        <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
        @if(isset($car) && $car->gallery && count($car->gallery))
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                @foreach($car->gallery as $img)
                    <img src="{{ asset('files/' . $img) }}"
                         style="width:70px;height:50px;object-fit:cover;border-radius:4px;border:1px solid #2a2a2c;"
                         onerror="this.style.display='none'">
                @endforeach
            </div>
            <div class="form-hint">Загрузка новых файлов заменит текущую галерею.</div>
        @endif
    </div>
</div>

<div class="form-section-title">Наличие</div>

<div class="form-row">
    <div class="form-group col">
        <label>Количество на складе</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $car->stock ?? 1) }}" min="0">
    </div>
</div>

<div class="form-check mb-2">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
           {{ old('is_active', $car->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active" style="text-transform:none;letter-spacing:0;color:#ece9e4;">Показывать на сайте</label>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
           {{ old('is_featured', $car->is_featured ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_featured" style="text-transform:none;letter-spacing:0;color:#ece9e4;">Показывать на главной (избранное)</label>
</div>

<div class="d-flex" style="gap:10px;padding-top:16px;border-top:1px solid #252527;">
    <button type="submit" class="btn btn-gold">{{ isset($car) ? 'Сохранить изменения' : 'Добавить автомобиль' }}</button>
    <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">Отмена</a>
</div>