<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'transaction_number',
        'product_id',
        'quantity',
        'supplier',
        'date',
        'description',
        'receipt_path',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
