<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_post';
    protected $primaryKey = 'post_id';
    protected $fillable = [
        'title', 'slug', 'summary', 'content',
        'author_id', 'is_published', 'published_at',
        'tags', 'image_url'
    ];

    public $timestamps = false;
}
