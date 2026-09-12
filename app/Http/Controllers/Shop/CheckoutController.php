<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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

            $items[] = ['car' => $car, 'qty' => $entry['qty'], 'subtotal' => $subtotal];
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста.');
        }

        $discountRate = Auth::user()->is_regular ? 0.02 : 0;
        $discount     = $total * $discountRate;
        $grandTotal   = $total - $discount;

        return view('shop.checkout', compact('items', 'total', 'discount', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'delivery_date'    => 'required|date|after:today',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста.');
        }

        $customer = Auth::user();
        $items    = [];
        $subtotal = 0;

        foreach ($cart as $carId => $entry) {
            $car = Car::find($carId);
            if (!$car) continue;

            $lineTotal  = $car->price * $entry['qty'];
            $subtotal  += $lineTotal;

            $items[] = ['car' => $car, 'qty' => $entry['qty'], 'unit_price' => $car->price, 'subtotal' => $lineTotal];
        }

        $discount   = $subtotal * $customer->discountRate();
        $grandTotal = $subtotal - $discount;

        $order = DB::transaction(function () use ($customer, $items, $subtotal, $discount, $grandTotal, $request) {
            $order = Order::create([
                'customer_id'      => $customer->id,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'total'            => $grandTotal,
                'status'           => 'pending',
                'sale_date'        => now()->toDateString(),
                'delivery_date'    => $request->delivery_date,
                'shipping_address' => $request->shipping_address,
                'shipping_phone'   => $request->shipping_phone,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'car_id'     => $item['car']->id,
                    'quantity'   => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'subtotal'   => $item['subtotal'],
                ]);
            }

            $customer->addSpending($grandTotal);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Заказ успешно оформлен!');
    }
}