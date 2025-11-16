<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionTarget extends Model
{
    use HasFactory;

    protected $table = 'promotion_target';
    protected $primaryKey = 'p_target_id';
    protected $fillable = ['promotion_id', 'target_type', 'target_id'];
    public $timestamps = false;

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
