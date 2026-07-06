<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display WMS Dashboard with summary metrics and charts.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $stockInMonth = StockIn::whereBetween('date', [$startOfMonth, $endOfMonth])->sum('quantity');
        $stockOutMonth = StockOut::whereBetween('date', [$startOfMonth, $endOfMonth])->sum('quantity');

        // Low stock count: current_stock <= minimum_stock or current_stock == 0
        $lowStockCount = Product::whereColumn('current_stock', '<=', 'minimum_stock')
            ->orWhere('current_stock', '<=', 0)
            ->count();

        // Recent Transactions (merged Stock In and Stock Out)
        $recentStockIns = StockIn::with('product')
            ->select('id', 'transaction_number', 'product_id', 'quantity', 'date', 'created_at', DB::raw("'Masuk' as type"))
            ->latest()
            ->take(5)
            ->get();

        $recentStockOuts = StockOut::with('product')
            ->select('id', 'transaction_number', 'product_id', 'quantity', 'date', 'created_at', DB::raw("'Keluar' as type"))
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = $recentStockIns->concat($recentStockOuts)
            ->sortByDesc('created_at')
            ->take(5);

        // Low Stock List (Top 5)
        $lowStockList = Product::with('category')
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->orWhere('current_stock', '<=', 0)
            ->orderBy('current_stock', 'asc')
            ->take(5)
            ->get();

        // Category distribution for pie chart
        $categoriesData = Category::withCount('products')->get();
        $categoryLabels = $categoriesData->pluck('name')->toArray();
        $categoryCounts = $categoriesData->pluck('products_count')->toArray();

        // Last 6 months trends for line chart
        $months = [];
        $stockInData = [];
        $stockOutData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $months[] = $monthDate->translatedFormat('F Y'); // Nama bulan

            // Query monthly Stock In
            $stockInSum = StockIn::whereYear('date', $monthDate->year)
                ->whereMonth('date', $monthDate->month)
                ->sum('quantity');
            $stockInData[] = (int) $stockInSum;

            // Query monthly Stock Out
            $stockOutSum = StockOut::whereYear('date', $monthDate->year)
                ->whereMonth('date', $monthDate->month)
                ->sum('quantity');
            $stockOutData[] = (int) $stockOutSum;
        }

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'stockInMonth',
            'stockOutMonth',
            'lowStockCount',
            'recentTransactions',
            'lowStockList',
            'categoryLabels',
            'categoryCounts',
            'months',
            'stockInData',
            'stockOutData'
        ));
    }
}
