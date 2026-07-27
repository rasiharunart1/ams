<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'rack_location' => 'nullable|string|max:50',
            'minimum_stock' => 'required|integer|min:0',
            'current_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // Default current_stock to 0 if not provided
        $validated['current_stock'] = $validated['current_stock'] ?? 0;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'rack_location' => 'nullable|string|max:50',
            'minimum_stock' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Prevent deletion if the product has transaction history
        if ($product->stockIns()->count() > 0 || $product->stockOuts()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Produk tidak dapat dihapus karena memiliki riwayat transaksi masuk/keluar.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Fetch product details as JSON.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('category'));
    }

    /**
     * Generate next product code based on prefix.
     */
    public function generateNextCode(Request $request)
    {
        $prefix = $request->query('prefix', 'PRD');
        
        // Find the latest product with this prefix
        $latestProduct = Product::where('code', 'like', "{$prefix}-%")->orderBy('code', 'desc')->first();
        
        if (!$latestProduct) {
            return response()->json(['code' => "{$prefix}-001"]);
        }
        
        // Extract the number and increment
        $parts = explode('-', $latestProduct->code);
        $number = intval(end($parts));
        $nextNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        
        return response()->json(['code' => "{$prefix}-{$nextNumber}"]);
    }
}
