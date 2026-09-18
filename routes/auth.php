<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Math captcha — no GD required, uses arithmetic from Lab Work 1
Route::get('/captcha', function () {
    $operations = ['+', '-', '*'];
    $op  = $operations[array_rand($operations)];
    $a   = random_int(2, 9);
    $b   = random_int(1, 9);

    // Prevent negative results for subtraction
    if ($op === '-' && $b > $a) [$a, $b] = [$b, $a];

    $answer = match($op) {
        '+'  => $a + $b,
        '-'  => $a - $b,
        '*'  => $a * $b,
    };

    session(['captcha_code' => (string) $answer]);
    session()->save();

    return response()->json([
        'question' => "{$a} {$op} {$b} = ?",
        'a'        => $a,
        'op'       => $op,
        'b'        => $b,
    ]);
})->name('captcha');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class,    'showForm'])->name('login');
    Route::post('/login',    [LoginController::class,    'login']);
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');