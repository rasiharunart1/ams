<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display report filters and preview.
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');

        $data = collect();

        if ($type) {
            $data = $this->getQueryData($type, $startDate, $endDate, $categoryId);
        }

        return view('reports.index', compact('categories', 'data', 'type', 'startDate', 'endDate', 'categoryId'));
    }

    /**
     * Export reports to CSV (Excel) or PDF (print layout).
     */
    public function export(Request $request)
    {
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryId = $request->input('category_id');
        $format = $request->input('format', 'excel');

        $data = $this->getQueryData($type, $startDate, $endDate, $categoryId);

        if ($format === 'excel') {
            return $this->exportCsv($type, $data);
        }

        // Print/PDF format
        return view('reports.print', compact('data', 'type', 'startDate', 'endDate'));
    }

    /**
     * Helper to fetch data based on filters.
     */
    private function getQueryData($type, $startDate, $endDate, $categoryId)
    {
        if ($type === 'stock_in') {
            $query = StockIn::with('product.category');
            if ($startDate) $query->whereDate('date', '>=', $startDate);
            if ($endDate) $query->whereDate('date', '<=', $endDate);
            if ($categoryId) {
                $query->whereHas('product', function($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            }
            return $query->latest('date')->get();
        } elseif ($type === 'stock_out') {
            $query = StockOut::with('product.category');
            if ($startDate) $query->whereDate('date', '>=', $startDate);
            if ($endDate) $query->whereDate('date', '<=', $endDate);
            if ($categoryId) {
                $query->whereHas('product', function($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            }
            return $query->latest('date')->get();
        } elseif ($type === 'inventory') {
            $query = Product::with('category');
            if ($categoryId) $query->where('category_id', $categoryId);
            return $query->orderBy('code')->get();
        }

        return collect();
    }

    /**
     * Helper to stream CSV download.
     */
    private function exportCsv($type, $data)
    {
        $filename = "laporan_{$type}_" . now()->format('Ymd_His') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($type, $data) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for MS Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            if ($type === 'stock_in') {
                fputcsv($file, ['No Transaksi', 'Tanggal', 'Kode Produk', 'Nama Produk', 'Kategori', 'Jumlah', 'Satuan', 'Pemasok', 'Keterangan']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->transaction_number,
                        $row->date->format('Y-m-d'),
                        $row->product->code,
                        $row->product->name,
                        $row->product->category->name,
                        $row->quantity,
                        $row->product->unit,
                        $row->supplier ?? '-',
                        $row->description ?? '-'
                    ]);
                }
            } elseif ($type === 'stock_out') {
                fputcsv($file, ['No Transaksi', 'Tanggal', 'Kode Produk', 'Nama Produk', 'Kategori', 'Jumlah', 'Satuan', 'Penerima', 'Tujuan Keperluan']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->transaction_number,
                        $row->date->format('Y-m-d'),
                        $row->product->code,
                        $row->product->name,
                        $row->product->category->name,
                        $row->quantity,
                        $row->product->unit,
                        $row->receiver ?? '-',
                        $row->purpose ?? '-'
                    ]);
                }
            } elseif ($type === 'inventory') {
                fputcsv($file, ['Kode Produk', 'Nama Produk', 'Kategori', 'Stok Saat Ini', 'Stok Minimum', 'Satuan', 'Lokasi Rak', 'Status']);
                foreach ($data as $row) {
                    $status = 'Safe';
                    if ($row->current_stock <= 0) {
                        $status = 'Out of Stock';
                    } elseif ($row->current_stock <= $row->minimum_stock) {
                        $status = 'Warning';
                    }
                    fputcsv($file, [
                        $row->code,
                        $row->name,
                        $row->category->name,
                        $row->current_stock,
                        $row->minimum_stock,
                        $row->unit,
                        $row->rack_location ?? '-',
                        $status
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
