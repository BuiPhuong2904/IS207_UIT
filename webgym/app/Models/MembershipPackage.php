<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class MembershipPackage extends Model
{
    use HasFactory;

    protected $table = 'membership_package';
    protected $primaryKey = 'package_id';
    protected $fillable = [
        'package_name', 'description', 'duration_months', 'price', 'slug', 'image_url', 'status', 'is_featured'
    ];

    public $timestamps = true;

    public function registrations()
    {
        return $this->hasMany(PackageRegistration::class, 'package_id');
    }

    protected $appends = ['features_list'];
    // Accessor để chuyển đổi description thành mảng features_list
    protected function featuresList(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (isset($attributes['description'])) {
                    // Tách chuỗi bằng ". " 
                    $features = explode('. ', $attributes['description']);
                    // Loại bỏ các mục rỗng
                    return array_filter($features, 'strlen');
                }
                return [];
            }
        );
    }

    public function getRouteKeyName()
    {
        return 'package_id';
    }
}