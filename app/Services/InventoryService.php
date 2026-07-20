<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Handle Stock In transaction
     *
     * @param array $data
     * @return StockIn
     * @throws Exception
     */
    public function addStock(array $data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            // Auto-generate transaction number if not provided
            $transactionNumber = $data['transaction_number'] ?? $this->generateTransactionNumber('IN');

            $stockIn = StockIn::create([
                'transaction_number' => $transactionNumber,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'supplier' => $data['supplier'] ?? null,
                'date' => $data['date'] ?? now()->toDateString(),
                'description' => $data['description'] ?? null,
                'receipt_path' => $data['receipt_path'] ?? null,
            ]);

            // Update current stock
            $product->current_stock += $data['quantity'];
            $product->save();

            return $stockIn;
        });
    }

    /**
     * Handle Stock Out transaction
     *
     * @param array $data
     * @return StockOut
     * @throws Exception
     */
    public function removeStock(array $data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            // Validation: Current stock must be greater than or equal to requested quantity
            if ($product->current_stock < $data['quantity']) {
                throw new Exception("Stok tidak mencukupi. Stok saat ini: {$product->current_stock}, diminta: {$data['quantity']}.");
            }

            // Auto-generate transaction number if not provided
            $transactionNumber = $data['transaction_number'] ?? $this->generateTransactionNumber('OUT');

            $stockOut = StockOut::create([
                'transaction_number' => $transactionNumber,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'receiver' => $data['receiver'] ?? null,
                'purpose' => $data['purpose'] ?? null,
                'date' => $data['date'] ?? now()->toDateString(),
                'receipt_path' => $data['receipt_path'] ?? null,
            ]);

            // Update current stock
            $product->current_stock -= $data['quantity'];
            $product->save();

            return $stockOut;
        });
    }

    /**
     * Reverse a Stock In transaction
     *
     * @param StockIn $stockIn
     * @throws Exception
     */
    public function reverseStockIn(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            $product = $stockIn->product;
            if ($product->current_stock < $stockIn->quantity) {
                throw new Exception("Tidak dapat membatalkan transaksi. Stok saat ini ({$product->current_stock}) kurang dari jumlah yang ingin dikurangi ({$stockIn->quantity}).");
            }
            $product->current_stock -= $stockIn->quantity;
            $product->save();
            $stockIn->delete();
        });
    }

    /**
     * Reverse a Stock Out transaction
     *
     * @param StockOut $stockOut
     */
    public function reverseStockOut(StockOut $stockOut)
    {
        DB::transaction(function () use ($stockOut) {
            $product = $stockOut->product;
            $product->current_stock += $stockOut->quantity;
            $product->save();
            $stockOut->delete();
        });
    }

    /**
     * Generate a unique transaction number
     *
     * @param string $prefix ('IN' or 'OUT')
     * @return string
     */
    public function generateTransactionNumber(string $prefix)
    {
        $dateStr = now()->format('Ymd');
        $randomStr = strtoupper(substr(uniqid(), -4));
        return "TRX-{$prefix}-{$dateStr}-{$randomStr}";
    }
}
