<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id'  => 'required|exists:cars,id',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'car_id'      => $request->car_id,
            'customer_id' => Auth::id(),
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'Спасибо за ваш отзыв!');
    }
}