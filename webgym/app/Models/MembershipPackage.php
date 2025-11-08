<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    use HasFactory;

    protected $table = 'membership_package';
    protected $primaryKey = 'package_id';
    protected $fillable = [
        'package_name', 'description', 'duration_months', 'price', 'slug','ímage_url'
    ];

    public $timestamps = false;

    public function registrations()
    {
        return $this->hasMany(PackageRegistration::class, 'package_id');
    }
}
