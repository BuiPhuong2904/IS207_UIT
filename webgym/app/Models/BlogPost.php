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


    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }
}
