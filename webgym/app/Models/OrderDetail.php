<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'order_id', 'variant_id', 'quantity',
        'unit_price', 'discount_value', 'final_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
