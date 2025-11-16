<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainer';
    protected $primaryKey = ['user_id'];
    protected $fillable = [
        'user_id', 'specialty', 'experience_years', 'salary',
        'work_schedule', 'branch_id', 'status'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function classes()
    {
        return $this->hasMany(GymClass::class, 'trainer_id');
    }
}
