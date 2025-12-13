<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class UserBlogController extends Controller
{
    public function index()
    {
        // 1. Lấy bài viết (Giữ nguyên)
        $allPosts = BlogPost::with('author')
            ->where('is_published', 1)
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->get();

        if ($allPosts->isEmpty()) {
            return view('user.blog.index', [
                'featuredPost' => null,
                'sidePosts' => collect(),
                'categoryPosts' => collect(),
                'uniqueTags' => collect(),
                'tagMapping' => [] // Trả về mảng rỗng để không lỗi
            ]);
        }

        // 2. Chia dữ liệu (Giữ nguyên)
        $featuredPost = $allPosts->first();
        $sidePosts = $allPosts->slice(1, 3);
        $categoryPosts = $allPosts;

        // 3. XỬ LÝ TAGS (PHẦN MỚI)
        
        // Lấy tất cả tag có trong DB ra
        $rawTags = $allPosts->pluck('tags_array')->flatten()->unique()->values();

        // A. Cấu hình Tên hiển thị Tiếng Việt
        $tagMapping = [
            'kien-thuc'  => 'Kiến Thức & Tập Luyện',
            'khuyen-mai' => 'Chương Trình Khuyến Mãi',
            'thong-bao'  => 'Thông Báo Từ Phòng Tập',
            'story'      => 'Câu Chuyện Khách Hàng',
        ];

        // B. Cấu hình Thứ tự hiển thị
        $priorityOrder = [
            'kien-thuc', 
            'khuyen-mai', 
            'thong-bao', 
            'story'
        ];

        // C. Sắp xếp $uniqueTags dựa trên $priorityOrder
        $uniqueTags = $rawTags->sortBy(function ($tag) use ($priorityOrder) {
            $index = array_search($tag, $priorityOrder);
            // Nếu tag không có trong list ưu tiên, cho xuống cuối (999)
            return $index === false ? 999 : $index;
        });

        // Trả về View 
        return view('user.blog', compact('featuredPost', 'sidePosts', 'categoryPosts', 'uniqueTags', 'tagMapping'));
    }
}