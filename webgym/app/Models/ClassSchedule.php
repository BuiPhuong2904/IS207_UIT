<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $table = 'class_schedule';
    protected $primaryKey = 'schedule_id';
    protected $fillable = [
        'class_id', 'date', 'start_time', 'end_time', 'room', 'status', 'trainer_id', 'branch_id'
    ];

    // public $timestamps = false;

    public function gymClass()
    {
        return $this->belongsTo(GymClass::class, 'class_id');
    }

    public function registrations()
    {
        return $this->hasMany(ClassRegistration::class, 'schedule_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // Accessor để định dạng schedule_id thành LL0001
    public function getFormattedIdAttribute() {
        return 'LL' . str_pad($this->schedule_id, 4, '0', STR_PAD_LEFT);
    }
}