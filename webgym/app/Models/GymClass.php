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
        'class_name', 'type', 'max_capacity',
        'description', 'is_active', 'image_url'
    ];

    public const TYPES = [
        'cardio'    => 'Cardio & Giảm mỡ',
        'strength'  => 'Strength & Tăng cơ',
        'mind_body' => 'Mind & Body',
        'combat'    => 'Combat (Võ thuật)',
        'dance'     => 'Dance (Nhảy hiện đại)',
    ];

    // public $timestamps = false;

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}