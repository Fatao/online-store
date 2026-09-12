<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('brand');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cars = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('cars'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Продукт добавлен.');
    }

    public function edit(Car $product)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Car $product)
    {
        $data = $this->validateProduct($request, $product);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Продукт обновлён.');
    }

    public function destroy(Car $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Продукт удалён.');
    }

    private function validateProduct(Request $request, ?Car $product = null): array
    {
        return $request->validate([
            'brand_id'      => 'required|exists:brands,id',
            'model'         => 'required|string|max:100',
            'name'          => 'required|string|max:150',
            'price'         => 'required|numeric|min:0',
            'unit'          => 'nullable|string|max:20',
            'year'          => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'mileage'       => 'nullable|integer|min:0',
            'horsepower'    => 'nullable|integer|min:0',
            'fuel_type'     => 'nullable|string|max:50',
            'transmission'  => 'nullable|string|max:50',
            'body_type'     => 'nullable|string|max:50',
            'color'         => 'nullable|string|max:50',
            'description'   => 'nullable|string',
            'features'      => 'nullable|string',
            'image'         => 'nullable|image|max:4096',
            'stock'         => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
            'is_featured'   => 'nullable|boolean',
        ]);
    }
}
