<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // chỉ admin đăng nhập mới vào được
    }

    // Trang danh sách blog (giao diện admin)
    public function index()
    {
        $blogs = BlogPost::with('author')->orderByDesc('post_id')->paginate(5);
        return view('admin.blogs', compact('blogs'));
    }


    // API: Lấy 1 bài để edit
    public function show($id)
    {
        $post = BlogPost::findOrFail($id);

        $tagsArray = $post->tags ? explode(',', $post->tags) : [];
        $tagsArray = array_map('trim', $tagsArray);

        return response()->json([
            'post_id'      => $post->post_id,
            'title'        => $post->title,
            'slug'         => $post->slug,
            'summary'      => $post->summary ?? '',
            'content'      => $post->content ?? '',
            'image_url'    => $post->image_url ?? '',
            'tags'         => $tagsArray,  // trả về array ['tag1', 'tag2']
            'published_at' => $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d') : null,
            'is_published' => (bool) $post->is_published,
        ]);
    }


    // === STORE ===
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        $isPublished = $request->boolean('is_published', false); // đúng cách lấy boolean

        BlogPost::create([
            'title'        => $request->title,
            'slug'         => \Str::slug($request->title),
            'content'      => $request->input('content'),
            'summary'      => $request->summary,
            'tags'         => $request->tags,
            'author_id'    => auth()->id(),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
            'image_url'    => $request->hasFile('image')
                ? $request->file('image')->store('images/blogs', 'public')
                : null,
        ]);

        return response()->json(['success' => true, 'message' => 'Thêm bài viết thành công!']);
    }

// === UPDATE ===
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        $isPublished = $request->boolean('is_published', false);

        $data = [
            'title'        => $request->title,
            'slug'         => \Str::slug($request->title),
            'content'      => $request->input('content'),
            'summary'      => $request->summary,
            'tags'         => $request->tags,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : $post->published_at,
        ];

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($post->image_url) {
                Storage::delete(str_replace('/storage/', 'public/', $post->image_url));
            }
            $data['image_url'] = $request->file('image')->store('images/blogs', 'public');
        }

        $post->update($data);

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công!']);
    }

    // Xóa
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa bài viết thành công!'
        ]);
    }
}
