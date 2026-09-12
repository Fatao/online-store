<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())->latest()->paginate(10);

        return view('orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->customer_id !== Auth::id(), 403);

        $order->load('items.car.brand');

        return view('orders.details', compact('order'));
    }
}