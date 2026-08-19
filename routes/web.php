<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AcquisitionController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepreciationController;
use App\Http\Controllers\DepreciationMethodController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\GeneralLedgerController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\TrialBalanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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

    Route::resource('journals', JournalController::class)->only(['index', 'show']);
    Route::get('ledger', [GeneralLedgerController::class, 'index'])->name('ledger.index');
    Route::get('ledger/{account}', [GeneralLedgerController::class, 'show'])->name('ledger.show');
    Route::get('trial-balance', [TrialBalanceController::class, 'index'])->name('trial-balance.index');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/neraca', [ReportController::class, 'neraca'])->name('reports.neraca');
    Route::get('reports/laba-rugi', [ReportController::class, 'labaRugi'])->name('reports.laba-rugi');
    Route::get('reports/nilai-buku-kategori', [ReportController::class, 'kategori'])->name('reports.kategori');
    Route::get('reports/kartu-aset', [ReportController::class, 'kartuAset'])->name('reports.kartu-aset');
    Route::get('reports/jadwal-penyusutan', [ReportController::class, 'jadwalPenyusutan'])->name('reports.jadwal-penyusutan');
    Route::get('reports/pelepasan', [ReportController::class, 'pelepasan'])->name('reports.pelepasan');
    Route::get('reports/arus-kas', [ReportController::class, 'arusKas'])->name('reports.arus-kas');

    Route::get('reports/neraca/pdf', [ReportExportController::class, 'neraca'])->name('reports.neraca.pdf');
    Route::get('reports/laba-rugi/pdf', [ReportExportController::class, 'labaRugi'])->name('reports.laba-rugi.pdf');
    Route::get('reports/nilai-buku-kategori/pdf', [ReportExportController::class, 'kategori'])->name('reports.kategori.pdf');
    Route::get('reports/kartu-aset/pdf', [ReportExportController::class, 'kartuAset'])->name('reports.kartu-aset.pdf');
    Route::get('reports/jadwal-penyusutan/pdf', [ReportExportController::class, 'jadwalPenyusutan'])->name('reports.jadwal-penyusutan.pdf');
    Route::get('reports/pelepasan/pdf', [ReportExportController::class, 'pelepasan'])->name('reports.pelepasan.pdf');
    Route::get('reports/arus-kas/pdf', [ReportExportController::class, 'arusKas'])->name('reports.arus-kas.pdf');

    Route::get('documentation', [DocumentationController::class, 'index'])->name('documentation.index');
    Route::get('documentation/{id}', [DocumentationController::class, 'show'])->name('documentation.show');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
