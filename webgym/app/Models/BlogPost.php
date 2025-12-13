<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_post';
    protected $primaryKey = 'post_id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'slug', 'summary', 'content',
        'author_id', 'is_published', 'published_at',
        'tags', 'image_url'
    ];

    // 1. Ép kiểu dữ liệu (Quan trọng để format ngày tháng trong View)
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime', // Để dùng được ->format('d/m/Y')
    ];

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    // 2. Accessor: Tự động chuyển chuỗi tags thành mảng
    // Khi gọi $post->tags_array sẽ nhận được ['Yoga', 'Health'] thay vì "Yoga, Health"
    public function getTagsArrayAttribute()
    {
        if (empty($this->tags)) return [];
        // Tách chuỗi bằng dấu phẩy và xóa khoảng trắng thừa
        return array_map('trim', explode(',', $this->tags));
    }
}