<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'status', 'phone', 'transaction_code', 'merchant_request_id', 'transaction_data', 'transaction_date', 'transaction_time', 'transaction_date_time'];

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
