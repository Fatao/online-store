<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Captcha image generator — session saved before image output
Route::get('/captcha', function () {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    $code  = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }

    // Save to session BEFORE any output and BEFORE exit
    session(['captcha_code' => strtolower($code)]);
    session()->save(); // critical: force save so exit doesn't lose it

    $img   = imagecreatetruecolor(160, 50);
    $bg    = imagecolorallocate($img, 14, 14, 14);
    $noise = imagecolorallocate($img, 40, 40, 40);
    imagefill($img, 0, 0, $bg);

    for ($i = 0; $i < 300; $i++) {
        imagesetpixel($img, random_int(0, 159), random_int(0, 49), $noise);
    }
    for ($i = 0; $i < 4; $i++) {
        imageline($img, random_int(0, 160), 0, random_int(0, 160), 50,
            imagecolorallocate($img, 30, 30, 30));
    }

    $font = 5;
    for ($i = 0; $i < strlen($code); $i++) {
        $col = imagecolorallocate($img, random_int(0, 80), random_int(180, 255), random_int(80, 180));
        imagestring($img, $font, 10 + $i * (imagefontwidth($font) + 4), random_int(8, 22), $code[$i], $col);
    }

    ob_start();
    imagepng($img);
    $imageData = ob_get_clean();
    imagedestroy($img);

    return response($imageData, 200)
        ->header('Content-Type', 'image/png')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
        ->header('Pragma', 'no-cache');

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