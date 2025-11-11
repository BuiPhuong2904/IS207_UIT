<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name', 'description', 'price', 'stock', 'image_url',
        'discount_price', 'is_discounted', 'slug', 'category_id',
        'brand', 'weight', 'unit', 'status'
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
