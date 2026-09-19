<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('cars')->orderBy('name')->paginate(20);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateBrand($request);
        $data['slug'] = str()->slug($data['name']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
            $this->copyToPublic($data['logo']);
        }

        Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success', 'Бренд добавлен.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $this->validateBrand($request);
        $data['slug'] = str()->slug($data['name']);

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
                $this->deleteFromPublic($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands', 'public');
            $this->copyToPublic($data['logo']);
        }

        $brand->update($data);
        return redirect()->route('admin.brands.index')->with('success', 'Бренд обновлён.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
            $this->deleteFromPublic($brand->logo);
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Бренд удалён.');
    }

    private function copyToPublic(string $path): void
    {
        $dir = public_path('files/' . dirname($path));
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        @copy(storage_path('app/public/' . $path), public_path('files/' . $path));
    }

    private function deleteFromPublic(string $path): void
    {
        $full = public_path('files/' . $path);
        if (file_exists($full)) @unlink($full);
    }

    private function validateBrand(Request $request): array
    {
        return $request->validate([
            'name'     => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'logo'     => 'nullable|image|max:2048',
            'featured' => 'nullable|boolean',
        ]);
    }
}
