<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('role', 'user')->withCount('orders')->latest()->paginate(15);

        return view('admin.users.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load('orders');

        return view('admin.users.show', compact('customer'));
    }

    public function toggleRegular(Customer $customer)
    {
        $customer->update(['is_regular' => !$customer->is_regular]);

        return back()->with('success', 'Статус VIP-клиента обновлён.');
    }
}