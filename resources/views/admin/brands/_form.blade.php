@csrf
@if(isset($brand)) @method('PUT') @endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="form-group">
    <label>Название бренда</label>
    <input type="text" name="name" value="{{ old('name', $brand->name ?? '') }}" required placeholder="Ferrari">
</div>

<div class="form-group">
    <label>Категория</label>
    <select name="category" required>
        <option value="">— Выберите категорию —</option>
        @foreach(\App\Models\Brand::categoryLabels() as $key => $label)
            <option value="{{ $key }}" {{ old('category', $brand->category ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Логотип</label>
    <input type="file" name="logo" accept="image/*">
    @if(isset($brand) && $brand->logo)
        <img src="{{ asset('storage/' . $brand->logo) }}" class="table-thumb" style="margin-top:10px; width:80px; height:80px;">
    @endif
</div>

<div class="form-check">
    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $brand->featured ?? false) ? 'checked' : '' }}>
    <label for="featured">Показывать на главной странице</label>
</div>

<div class="form-actions">
    <button type="submit" class="btn-primary-sm">{{ isset($brand) ? 'Сохранить изменения' : 'Добавить бренд' }}</button>
    <a href="{{ route('admin.brands.index') }}" class="btn-ghost-sm">Отмена</a>
</div>