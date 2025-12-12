<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // public $timestamps = false;

    public function targets()
    {
        return $this->hasMany(PromotionTarget::class, 'promotion_id');
    }

    public function getUsedCountAttribute()
    {
        return \DB::table('order')
            ->where('promotion_code', $this->code)
            ->whereIn('status', ['processing', 'completed', 'shipped', 'done'])
            ->count();
    }

    public function scopeActive($query)
    {
        $now = Carbon::now();

        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });
    }
}
