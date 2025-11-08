<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageRegistration extends Model
{
    use HasFactory;

    protected $table = 'package_registration';
    protected $primaryKey = 'registration_id';
    protected $fillable = [
        'user_id', 'package_id', 'start_date', 'end_date', 'status', 'payment_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(MembershipPackage::class, 'package_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
