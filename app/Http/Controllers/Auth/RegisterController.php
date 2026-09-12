<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate all fields including captcha
        $request->validate([
            'name'     => 'required|string|min:2|max:100',
            'email'    => 'required|email|unique:customers,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'captcha'  => 'required|string',
        ]);

        // Check captcha
        $captchaInput = strtolower(trim($request->captcha));
        $captchaReal  = session('captcha_code', '');
        session()->forget('captcha_code'); // single-use

        if ($captchaInput !== $captchaReal) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'captcha'))
                ->withErrors(['captcha' => 'Неверный код капчи. Попробуйте снова.']);
        }

        // Create customer
        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($customer);

        return redirect()->route('home')->with('success', 'Добро пожаловать, ' . $customer->name . '!');
    }
}