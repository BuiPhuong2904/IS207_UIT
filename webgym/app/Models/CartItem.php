<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_item';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cart_id', ' variant_id', 'quantity', 'unit_price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
