<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the inventory stock monitoring page.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search product
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'safe') {
                $query->whereColumn('current_stock', '>', 'minimum_stock')
                      ->where('current_stock', '>', 0);
            } elseif ($status === 'warning') {
                $query->whereColumn('current_stock', '<=', 'minimum_stock')
                      ->where('current_stock', '>', 0);
            } elseif ($status === 'danger') {
                $query->where('current_stock', '<=', 0);
            }
        }

        $products = $query->orderBy('code')->paginate(15)->withQueryString();

        return view('inventory.index', compact('products'));
    }

    /**
     * API for fetching low stock products (used for notifications in layout topbar)
     */
    public function lowStockNotifications()
    {
        $lowStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')
                                    ->orWhere('current_stock', '<=', 0)
                                    ->orderBy('current_stock', 'asc')
                                    ->take(5)
                                    ->get(['id', 'code', 'name', 'current_stock', 'minimum_stock']);

        return response()->json($lowStockProducts);
    }
}
