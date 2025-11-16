<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotion';
    protected $primaryKey = 'promotion_id';
    protected $fillable = [
        'code', 'title', 'description', 'discount_value', 'is_percent',
        'start_date', 'end_date', 'min_order_amount', 'max_discount',
        'usage_limit', 'per_user_limit', 'is_active'
    ];

    public $timestamps = false;

    public function targets()
    {
        return $this->hasMany(PromotionTarget::class, 'promotion_id');
    }
}
