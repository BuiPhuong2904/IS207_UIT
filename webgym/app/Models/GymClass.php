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

    // public $timestamps = false;

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}