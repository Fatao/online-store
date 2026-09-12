<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /** Home page — hero, featured brands, featured cars */
    public function home()
    {
        $featured       = Car::with('brand')->where('is_active', true)->where('is_featured', true)->latest()->take(8)->get();
        $featuredBrands = Brand::where('featured', true)->withCount('cars')->orderBy('name')->get();

        return view('shop.home', compact('featured', 'featuredBrands'));
    }

    /** Full inventory with search + filters */
    public function index(Request $request)
    {
        $brands = Brand::withCount('cars')->orderBy('name')->get();

        $query = Car::with('brand')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('body_type')) {
            $query->where('body_type', $request->body_type);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($request->sort === 'price_desc') {
            $query->orderByDesc('price');
        } else {
            $query->latest();
        }

        $cars = $query->paginate(12)->withQueryString();

        return view('shop.inventory', compact('cars', 'brands'));
    }

    /** Single car detail page */
    public function show(Car $car)
    {
        $car->load(['brand', 'reviews.customer']);

        $related = Car::where('brand_id', $car->brand_id)
                       ->where('id', '!=', $car->id)
                       ->take(4)->get();

        return view('shop.show', compact('car', 'related'));
    }
}