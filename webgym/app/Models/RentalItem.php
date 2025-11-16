<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    use HasFactory;

    protected $table = 'rental_item';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_name', 'description', 'rental_fee', 'quantity_total',
        'quantity_available', 'branch_id','ímage_url', 'status'
    ];

    public $timestamps = false;

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function transactions()
    {
        return $this->hasMany(RentalTransaction::class, 'item_id');
    }
}
