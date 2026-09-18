<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function home()
    {
        $featured       = Car::with('brand')->where('is_active', true)->where('is_featured', true)->latest()->take(8)->get();
        $featuredBrands = Brand::where('featured', true)->withCount('cars')->orderBy('name')->get();

        return view('shop.home', compact('featured', 'featuredBrands'));
    }

    public function index(Request $request)
    {
        $brands = Brand::orderBy('name')->get();

        // ── Main filtered query ──────────────────────────────────────────
        $query = Car::with('brand')->where('is_active', true);

        if ($request->filled('search'))       $query->where('name', 'like', '%'.$request->search.'%');
        if ($request->filled('brand'))        $query->where('brand_id', $request->brand);
        if ($request->filled('fuel_type'))    $query->where('fuel_type', $request->fuel_type);
        if ($request->filled('transmission')) $query->where('transmission', $request->transmission);
        if ($request->filled('body_type'))    $query->where('body_type', $request->body_type);
        if ($request->filled('price_min'))    $query->where('price', '>=', $request->price_min);
        if ($request->filled('price_max'))    $query->where('price', '<=', $request->price_max);

        if ($request->sort === 'price_asc')        $query->orderBy('price');
        elseif ($request->sort === 'price_desc')   $query->orderByDesc('price');
        else                                        $query->latest();

        $cars = $query->paginate(12)->withQueryString();

        // ── Faceted counts ───────────────────────────────────────────────
        // Each facet counts cars matching ALL active filters EXCEPT its own.
        // This way the number shown reflects how many results you'd get
        // if you picked that option alongside your current other filters.

        // Brand counts — apply every filter EXCEPT brand
        $brandCounts = Car::where('is_active', true)
            ->when($request->filled('fuel_type'),    fn($q) => $q->where('fuel_type',    $request->fuel_type))
            ->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->transmission))
            ->when($request->filled('body_type'),    fn($q) => $q->where('body_type',    $request->body_type))
            ->when($request->filled('price_min'),    fn($q) => $q->where('price', '>=',  $request->price_min))
            ->when($request->filled('price_max'),    fn($q) => $q->where('price', '<=',  $request->price_max))
            ->when($request->filled('search'),       fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->selectRaw('brand_id, count(*) as cnt')
            ->groupBy('brand_id')
            ->pluck('cnt', 'brand_id');

        // Transmission counts — apply every filter EXCEPT transmission
        $transmissionCounts = Car::where('is_active', true)
            ->whereNotNull('transmission')
            ->when($request->filled('brand'),      fn($q) => $q->where('brand_id',   $request->brand))
            ->when($request->filled('fuel_type'),  fn($q) => $q->where('fuel_type',  $request->fuel_type))
            ->when($request->filled('body_type'),  fn($q) => $q->where('body_type',  $request->body_type))
            ->when($request->filled('price_min'),  fn($q) => $q->where('price', '>=', $request->price_min))
            ->when($request->filled('price_max'),  fn($q) => $q->where('price', '<=', $request->price_max))
            ->when($request->filled('search'),     fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->selectRaw('transmission, count(*) as cnt')
            ->groupBy('transmission')
            ->pluck('cnt', 'transmission');

        // Fuel type counts — apply every filter EXCEPT fuel_type
        $fuelCounts = Car::where('is_active', true)
            ->whereNotNull('fuel_type')
            ->when($request->filled('brand'),        fn($q) => $q->where('brand_id',     $request->brand))
            ->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->transmission))
            ->when($request->filled('body_type'),    fn($q) => $q->where('body_type',    $request->body_type))
            ->when($request->filled('price_min'),    fn($q) => $q->where('price', '>=',  $request->price_min))
            ->when($request->filled('price_max'),    fn($q) => $q->where('price', '<=',  $request->price_max))
            ->when($request->filled('search'),       fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->selectRaw('fuel_type, count(*) as cnt')
            ->groupBy('fuel_type')
            ->pluck('cnt', 'fuel_type');

        // Body type counts — apply every filter EXCEPT body_type
        $bodyCounts = Car::where('is_active', true)
            ->whereNotNull('body_type')
            ->when($request->filled('brand'),        fn($q) => $q->where('brand_id',     $request->brand))
            ->when($request->filled('fuel_type'),    fn($q) => $q->where('fuel_type',    $request->fuel_type))
            ->when($request->filled('transmission'), fn($q) => $q->where('transmission', $request->transmission))
            ->when($request->filled('price_min'),    fn($q) => $q->where('price', '>=',  $request->price_min))
            ->when($request->filled('price_max'),    fn($q) => $q->where('price', '<=',  $request->price_max))
            ->when($request->filled('search'),       fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->selectRaw('body_type, count(*) as cnt')
            ->groupBy('body_type')
            ->pluck('cnt', 'body_type');

        return view('shop.inventory', compact(
            'cars', 'brands',
            'brandCounts', 'transmissionCounts', 'fuelCounts', 'bodyCounts'
        ));
    }

    public function show(Car $car)
    {
        $car->load(['brand', 'reviews.customer']);

        $related = Car::where('brand_id', $car->brand_id)
                       ->where('id', '!=', $car->id)
                       ->take(4)->get();

        return view('shop.show', compact('car', 'related'));
    }
}