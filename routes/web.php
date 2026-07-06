<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect welcome page to dashboard/login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('products', ProductController::class);

    // Transactions
    Route::resource('stock-in', StockInController::class)->only(['index', 'store', 'destroy']);
    Route::resource('stock-out', StockOutController::class)->only(['index', 'store', 'destroy']);

    // Monitoring
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/api/low-stock-notifications', [InventoryController::class, 'lowStockNotifications'])->name('api.low-stock');

    // Reports
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
