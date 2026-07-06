<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Exception;

class StockOutController extends Controller
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
        $query = StockOut::with('product.category');

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

        $stockOuts = $query->latest()->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock-out.index', compact('stockOuts', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'nullable|string|max:50|unique:stock_outs,transaction_number',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'receiver' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        try {
            $this->inventoryService->removeStock($validated);
            return redirect()->route('stock-out.index')->with('success', 'Transaksi barang keluar berhasil dicatat.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOut $stockOut)
    {
        try {
            $this->inventoryService->reverseStockOut($stockOut);
            return redirect()->route('stock-out.index')->with('success', 'Transaksi keluar berhasil dibatalkan dan stok produk dikembalikan.');
        } catch (Exception $e) {
            return redirect()->route('stock-out.index')->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
}
