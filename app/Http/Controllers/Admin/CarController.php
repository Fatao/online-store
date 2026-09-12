<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('brand');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cars = $query->latest()->paginate(15)->withQueryString();

        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.cars.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCar($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Автомобиль добавлен.');
    }

    public function edit(Car $car)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $this->validateCar($request, $car);

        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Автомобиль обновлён.');
    }

    public function destroy(Car $car)
    {
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Автомобиль удалён.');
    }

    private function validateCar(Request $request, ?Car $car = null): array
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