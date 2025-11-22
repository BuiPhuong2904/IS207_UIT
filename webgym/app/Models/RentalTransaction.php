<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalTransaction extends Model
{
    use HasFactory;

    protected $table = 'rental_transaction';
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'user_id', 'item_id', 'quantity', 'borrow_date',
        'return_date', 'status', 'note'
    ];

    // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsTo(RentalItem::class, 'item_id');
    }
}
