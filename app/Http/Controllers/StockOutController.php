<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class StockOutController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $query = StockOut::with('product.category');

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

        $stockOuts = $query->latest()->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('stock-out.index', compact('stockOuts', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'nullable|string|max:50|unique:stock_outs,transaction_number',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'receiver' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'date' => 'required|date',
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('receipt_file')) {
            $validated['receipt_path'] = $request->file('receipt_file')->store('receipts/stock-out', 'public');
        }

        try {
            $this->inventoryService->removeStock($validated);
            return redirect()->route('stock-out.index')->with('success', 'Transaksi barang keluar berhasil dicatat.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load('product.category');
        return view('stock-out.show', compact('stockOut'));
    }

    public function updateReceipt(Request $request, StockOut $stockOut)
    {
        $request->validate([
            'receipt_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($stockOut->receipt_path) {
            Storage::disk('public')->delete($stockOut->receipt_path);
        }

        $stockOut->update([
            'receipt_path' => $request->file('receipt_file')->store('receipts/stock-out', 'public'),
        ]);

        return redirect()->back()->with('success', 'Bukti kwitansi berhasil diperbarui.');
    }

    public function deleteReceipt(StockOut $stockOut)
    {
        if ($stockOut->receipt_path) {
            Storage::disk('public')->delete($stockOut->receipt_path);
            $stockOut->update(['receipt_path' => null]);
        }

        return redirect()->back()->with('success', 'Bukti kwitansi berhasil dihapus.');
    }

    public function destroy(StockOut $stockOut)
    {
        try {
            if ($stockOut->receipt_path) {
                Storage::disk('public')->delete($stockOut->receipt_path);
            }
            $this->inventoryService->reverseStockOut($stockOut);
            return redirect()->route('stock-out.index')->with('success', 'Transaksi keluar berhasil dibatalkan dan stok produk dikembalikan.');
        } catch (Exception $e) {
            return redirect()->route('stock-out.index')->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    public function receipt(StockOut $stockOut)
    {
        $stockOut->load('product.category');
        return view('stock-out.receipt', compact('stockOut'));
    }
}
