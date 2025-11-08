<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'user_id', 'payment_type', 'amount', 'method',
        'payment_date', 'status', 'order_id', 'package_registration_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function packageRegistration()
    {
        return $this->belongsTo(PackageRegistration::class, 'package_registration_id');
    }
}
