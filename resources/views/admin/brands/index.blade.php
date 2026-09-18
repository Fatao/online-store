@extends('layouts.admin')
@section('page-title', ' Бренды')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0" style="color:#c9a86a;font-size:1rem;">Список брендов</h3>
        <a href="{{ route('admin.brands.create') }}"
           style="background:#c9a86a;color:#0b0b0d;border:none;padding:7px 18px;border-radius:4px;font-size:0.82rem;font-weight:600;letter-spacing:1px;text-decoration:none;">
            + Добавить бренд
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0" style="border-collapse:separate;">
            <thead>
                <tr style="background:#111113;">
                    <th style="width:60px;color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;">Лого</th>
                    <th style="color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;">Название</th>
                    <th style="color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;">Категория</th>
                    <th style="width:110px;color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;text-align:center;">Авто</th>
                    <th style="width:110px;color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;text-align:center;">На главной</th>
                    <th style="width:200px;color:#c9a86a;font-size:0.72rem;letter-spacing:1.5px;text-transform:uppercase;border-bottom:1px solid #2a2a2c;padding:12px 16px;">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr style="border-bottom:1px solid #1e1e20;">
                        <td style="padding:14px 16px;">
                            @if($brand->logo)
                                <img src="{{ asset('files/' . $brand->logo) }}"
                                     style="width:44px;height:44px;object-fit:cover;border-radius:4px;border:1px solid #2a2a2c;"
                                     onerror="this.style.display='none'">
                            @else
                                <div style="width:44px;height:44px;background:#1e1e20;border-radius:4px;border:1px solid #2a2a2c;display:flex;align-items:center;justify-content:center;color:#444;font-size:1.1rem;">🏷</div>
                            @endif
                        </td>
                        <td style="padding:14px 16px;">
                            <span style="color:#ffffff;font-weight:600;font-size:0.95rem;">{{ $brand->name }}</span>
                        </td>
                        <td style="padding:14px 16px;">
                            <span style="color:#b0ada8;font-size:0.86rem;">
                                {{ \App\Models\Brand::categoryLabels()[$brand->category] ?? $brand->category }}
                            </span>
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            <span style="color:#c9a86a;font-family:monospace;font-size:0.95rem;font-weight:600;">{{ $brand->cars_count }}</span>
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            @if($brand->featured)
                                <span style="color:#c9a86a;font-size:0.85rem;font-weight:600;">★ Да</span>
                            @else
                                <span style="color:#444;font-size:0.85rem;">Нет</span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;">
                            <div style="display:flex;gap:8px;">
                                <a href="{{ route('admin.brands.edit', $brand) }}"
                                   style="padding:6px 14px;border:1px solid #c9a86a;color:#c9a86a;border-radius:4px;font-size:0.78rem;text-decoration:none;letter-spacing:0.5px;transition:all .2s;">
                                    Изменить
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                      style="margin:0;" onsubmit="return confirm('Удалить бренд?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="padding:6px 14px;border:1px solid #e2566b;color:#e2566b;background:transparent;border-radius:4px;font-size:0.78rem;cursor:pointer;letter-spacing:0.5px;">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#555;">Бренды не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($brands->hasPages())
        <div class="card-footer" style="background:#1a1a1c;border-top:1px solid #252527;">
            {{ $brands->links() }}
        </div>
    @endif
</div>

@endsection