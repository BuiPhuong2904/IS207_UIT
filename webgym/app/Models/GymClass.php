<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $primaryKey = 'class_id';
    protected $fillable = [
        'class_name', 'trainer_id', 'type', 'max_capacity',
        'description', 'is_active', 'branch_id','ímage_url'
    ];

    public $timestamps = false;

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
