<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    /** Brands page — grouped by category */
    public function index()
    {
        $brands = Brand::withCount('cars')->orderBy('name')->get();
        $groups = $brands->groupBy('category');
        $labels = Brand::categoryLabels();

        return view('shop.brands', compact('groups', 'labels'));
    }

    /** Cars for a single brand */
    public function show(Brand $brand)
    {
        $cars = $brand->cars()->where('is_active', true)->paginate(12);

        return view('shop.brand_cars', compact('brand', 'cars'));
    }
}