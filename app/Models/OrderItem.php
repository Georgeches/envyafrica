<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'order_id', 'price', 'quantity'];

    function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
    function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
