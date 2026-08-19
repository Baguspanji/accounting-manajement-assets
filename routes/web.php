<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StudyCaseController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('members', MemberController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('contracts', ContractController::class);
    
    Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{id}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('study-cases', [StudyCaseController::class, 'index'])->name('study-cases.index');
    Route::get('study-cases/{id}', [StudyCaseController::class, 'show'])->name('study-cases.show');
});
