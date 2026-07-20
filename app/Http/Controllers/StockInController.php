<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class StockInController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $query = StockIn::with('product.category');

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

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $stockIns = $query->latest()->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock-in.index', compact('stockIns', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'nullable|string|max:50|unique:stock_ins,transaction_number',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('receipt_file')) {
            $validated['receipt_path'] = $request->file('receipt_file')->store('receipts/stock-in', 'public');
        }

        try {
            $this->inventoryService->addStock($validated);
            return redirect()->route('stock-in.index')->with('success', 'Transaksi barang masuk berhasil dicatat.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load('product.category');
        return view('stock-in.show', compact('stockIn'));
    }

    public function updateReceipt(Request $request, StockIn $stockIn)
    {
        $request->validate([
            'receipt_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($stockIn->receipt_path) {
            Storage::disk('public')->delete($stockIn->receipt_path);
        }

        $stockIn->update([
            'receipt_path' => $request->file('receipt_file')->store('receipts/stock-in', 'public'),
        ]);

        return redirect()->back()->with('success', 'Bukti kwitansi berhasil diperbarui.');
    }

    public function deleteReceipt(StockIn $stockIn)
    {
        if ($stockIn->receipt_path) {
            Storage::disk('public')->delete($stockIn->receipt_path);
            $stockIn->update(['receipt_path' => null]);
        }

        return redirect()->back()->with('success', 'Bukti kwitansi berhasil dihapus.');
    }

    public function destroy(StockIn $stockIn)
    {
        try {
            if ($stockIn->receipt_path) {
                Storage::disk('public')->delete($stockIn->receipt_path);
            }
            $this->inventoryService->reverseStockIn($stockIn);
            return redirect()->route('stock-in.index')->with('success', 'Transaksi masuk berhasil dibatalkan dan stok produk disesuaikan.');
        } catch (Exception $e) {
            return redirect()->route('stock-in.index')->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    public function receipt(StockIn $stockIn)
    {
        $stockIn->load('product.category');
        return view('stock-in.receipt', compact('stockIn'));
    }
}
