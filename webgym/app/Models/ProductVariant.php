<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variant';
    protected $primaryKey = 'variant_id';

    protected $fillable = [
        'product_id', 'color', 'size', 'price', 'discount_price',
        'is_discounted', 'stock', 'image_url', 'status',
        'weight', 'unit'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
