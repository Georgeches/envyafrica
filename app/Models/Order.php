<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['shipping_price', 'notes', 'amount', 'number', 'status', 'customer_id', 'payment_id'];

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    public function payment(): HasOne{
        return $this->hasOne(Payment::class);
    }

    public function order_items(): HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
