<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'full_name', 'email', 'password', 'role', 'phone',
        'birth_date', 'gender', 'address','ímage_url', 'status'
    ];

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'user_id');
    }

    public function packageRegistrations()
    {
        return $this->hasMany(PackageRegistration::class, 'user_id');
    }

    public function classRegistrations()
    {
        return $this->hasMany(ClassRegistration::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function managedBranch()
    {
        return $this->hasOne(Branch::class, 'manager_id');
    }

    public function rentalTransactions()
    {
        return $this->hasMany(RentalTransaction::class, 'user_id');
    }

    public function blog()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
