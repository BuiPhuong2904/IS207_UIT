<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalTransaction extends Model
{
    protected $table = 'rental_transaction';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'borrow_date',
        'return_date',
        'status',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsTo(RentalItem::class, 'item_id');
    }
}
