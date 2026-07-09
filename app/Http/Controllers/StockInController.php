<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Exception;

class StockInController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockIn::with('product.category');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                  ->orWhereHas('product', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $stockIns = $query->latest()->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock-in.index', compact('stockIns', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'nullable|string|max:50|unique:stock_ins,transaction_number',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $this->inventoryService->addStock($validated);
            return redirect()->route('stock-in.index')->with('success', 'Transaksi barang masuk berhasil dicatat.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockIn $stockIn)
    {
        try {
            $this->inventoryService->reverseStockIn($stockIn);
            return redirect()->route('stock-in.index')->with('success', 'Transaksi masuk berhasil dibatalkan dan stok produk disesuaikan.');
        } catch (Exception $e) {
            return redirect()->route('stock-in.index')->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Show printable receipt for a stock-in transaction.
     */
    public function receipt(StockIn $stockIn)
    {
        $stockIn->load('product.category');
        return view('stock-in.receipt', compact('stockIn'));
    }
}
