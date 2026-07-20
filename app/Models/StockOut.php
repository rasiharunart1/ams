<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'transaction_number',
        'product_id',
        'quantity',
        'receiver',
        'purpose',
        'date',
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
