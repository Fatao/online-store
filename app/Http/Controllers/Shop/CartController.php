<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $carId => $entry) {
            $car = Car::find($carId);
            if (!$car) continue;

            $subtotal = $car->price * $entry['qty'];
            $total   += $subtotal;

            $items[] = [
                'car'      => $car,
                'qty'      => $entry['qty'],
                'subtotal' => $subtotal,
            ];
        }

        $discountRate = auth()->check() && auth()->user()->is_regular ? 0.02 : 0;
        $discount     = $total * $discountRate;
        $grandTotal   = $total - $discount;

        return view('shop.cart', compact('items', 'total', 'discount', 'grandTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'qty'    => 'nullable|integer|min:1',
        ]);

        $cart  = session('cart', []);
        $carId = $request->car_id;
        $qty   = $request->qty ?? 1;

        $cart[$carId] = ['qty' => ($cart[$carId]['qty'] ?? 0) + $qty];

        session(['cart' => $cart]);

        return back()->with('success', 'Автомобиль добавлен в корзину.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'qty'    => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        if (isset($cart[$request->car_id])) {
            $cart[$request->car_id]['qty'] = $request->qty;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Корзина обновлена.');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->car_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Автомобиль удалён из корзины.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Корзина очищена.');
    }
}