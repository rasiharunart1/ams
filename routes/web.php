<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'superadmin' 
            ? redirect()->route('superadmin.dashboard') 
            : redirect()->route('dashboard');
    }
    return view('welcome');
});

// Authentication protected routes (Apoteker Only)
Route::middleware(['auth', 'verified', 'subscription', 'apoteker'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::get('/api/products/next-code', [ProductController::class, 'generateNextCode'])->name('api.products.next-code');
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('products', ProductController::class);

    // Transactions
    Route::resource('stock-in', StockInController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::get('stock-in/{stockIn}/receipt', [StockInController::class, 'receipt'])->name('stock-in.receipt');
    Route::post('stock-in/{stockIn}/receipt', [StockInController::class, 'updateReceipt'])->name('stock-in.update-receipt');
    Route::delete('stock-in/{stockIn}/receipt', [StockInController::class, 'deleteReceipt'])->name('stock-in.delete-receipt');

    Route::resource('stock-out', StockOutController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::get('stock-out/{stockOut}/receipt', [StockOutController::class, 'receipt'])->name('stock-out.receipt');
    Route::post('stock-out/{stockOut}/receipt', [StockOutController::class, 'updateReceipt'])->name('stock-out.update-receipt');
    Route::delete('stock-out/{stockOut}/receipt', [StockOutController::class, 'deleteReceipt'])->name('stock-out.delete-receipt');

    // Monitoring
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/api/low-stock-notifications', [InventoryController::class, 'lowStockNotifications'])->name('api.low-stock');

    // Reports & Analysis
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
    Route::get('/analysis', [App\Http\Controllers\ReportController::class, 'analysis'])->name('analysis.index');
    Route::get('/api/analysis/product-movement', [App\Http\Controllers\ReportController::class, 'productMovement'])->name('api.analysis.product-movement');

    // Reset Data
    Route::post('/reset-data', [App\Http\Controllers\SuperAdminController::class, 'resetData'])->name('apoteker.reset-data');
});

// Profile Settings (All authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Superadmin Routes
Route::middleware(['auth', 'verified', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('users.index');
    Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [App\Http\Controllers\SuperAdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\SuperAdminController::class, 'destroy'])->name('users.destroy');
    Route::post('/reset-data', [App\Http\Controllers\SuperAdminController::class, 'resetData'])->name('reset-data');
});

require __DIR__.'/auth.php';
