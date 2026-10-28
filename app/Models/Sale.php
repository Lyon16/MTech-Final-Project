<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $table = 'sales';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'customer_id',
        'sold_by',
        'quantity',
        'total_price',
        'created_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by');
    }
}
