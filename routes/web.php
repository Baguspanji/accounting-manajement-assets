<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepreciationController;
use App\Http\Controllers\DepreciationMethodController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\DocumentationController;
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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('assets', AssetController::class);
    Route::resource('asset-categories', AssetCategoryController::class);
    Route::resource('depreciation-methods', DepreciationMethodController::class);
    Route::resource('accounts', AccountController::class);

    Route::resource('acquisitions', AcquisitionController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('depreciations', [DepreciationController::class, 'index'])->name('depreciations.index');
    Route::post('depreciations/run', [DepreciationController::class, 'run'])->name('depreciations.run');
    Route::post('depreciations/post', [DepreciationController::class, 'post'])->name('depreciations.post');
    Route::resource('disposals', DisposalController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('documentation', [DocumentationController::class, 'index'])->name('documentation.index');
    Route::get('documentation/{id}', [DocumentationController::class, 'show'])->name('documentation.show');
});
