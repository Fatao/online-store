<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $cars   = Car::where('is_active', true)->orderBy('name')->get();
        $result = null;

        if ($request->isMethod('post')) {
            $result = $this->calculate(
                (float) $request->input('price'),
                (float) $request->input('down_payment', 0),
                (int) $request->input('months')
            );
        }

        return view('shop.finance', compact('cars', 'result'));
    }

    public function calculate(float $price, float $downPayment, int $months): array
    {
        $months = max(1, $months);
        $financedAmount = max(0, $price - $downPayment);
        $monthlyPayment = $financedAmount / $months;

        return [
            'price'           => $price,
            'down_payment'    => $downPayment,
            'months'          => $months,
            'financed_amount' => $financedAmount,
            'monthly_payment' => round($monthlyPayment, 2),
        ];
    }
}