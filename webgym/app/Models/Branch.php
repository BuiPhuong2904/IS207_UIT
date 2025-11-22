<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';
    protected $fillable = [
        'branch_name', 'address', 'phone', 'manager_id', 'is_active'
    ];

    // public $timestamps = false;

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'branch_id');
    }

    public function classes()
    {
        return $this->hasMany(GymClass::class, 'branch_id');
    }

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class, 'branch_id');
    }
}
