@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

@php
    // 1. Helper function tạo bài viết
    $createMockPost = function($id, $title, $img, $tags = [], $date = '2025-12-03') {
        return (object)[
            'post_id'      => $id,
            'title'        => $title,
            'slug'         => \Illuminate\Support\Str::slug($title) . '-' . $id,
            'summary'      => 'Mô tả ngắn...',
            'content'      => 'Nội dung chi tiết...',
            'author_id'    => 1,
            'author_name'  => 'Guy Hawkins',
            'is_published' => true,
            'published_at' => $date,
            'image_url'    => $img,
            'tags'         => $tags, // Array các tag: ['Yoga', 'Health']
        ];
    };

    // 2. Data cho phần Hero (Bài nổi bật & Side list) - Giữ nguyên logic cũ
    $featuredPost = $createMockPost(1, 'Tiêu đề gì đó ở đây', 'https://th.bing.com/th/id/R.6e757face53bc31e059437f30aed7ac2?rik=JdClRyfIPNzkog&pid=ImgRaw&r=0', ['Military']);
    
    $sidePosts = collect();
    for($i=1; $i<=3; $i++) {
        $sidePosts->push($createMockPost($i+1, 'The global financial landscape '.$i, 'https://th.bing.com/th/id/R.6e757face53bc31e059437f30aed7ac2?rik=JdClRyfIPNzkog&pid=ImgRaw&r=0', ['News']));
    }

    // 3. Data cho các Section dưới (Trộn lẫn nhiều tag)
    $categoryPosts = collect();

    // - Tạo 4 bài Yoga
    for($i=1; $i<=4; $i++) {
        $categoryPosts->push($createMockPost($i+10, '5 Lợi ích của việc tập Yoga hàng ngày '.$i, 'https://th.bing.com/th/id/R.6e757face53bc31e059437f30aed7ac2?rik=JdClRyfIPNzkog&pid=ImgRaw&r=0', ['Yoga']));
    }

    // - Tạo 4 bài Cardio
    for($i=1; $i<=4; $i++) {
        $categoryPosts->push($createMockPost($i+20, '10 Bài tập Cardio hiệu quả tại nhà '.$i, 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=600&auto=format&fit=crop', ['Cardio']));
    }

    // - Tạo thêm 4 bài Military (để test xem vòng lặp có tự sinh ra section mới không)
    for($i=1; $i<=4; $i++) {
        $categoryPosts->push($createMockPost($i+30, 'Các khí tài quân sự hiện đại '.$i, 'https://th.bing.com/th/id/R.6e757face53bc31e059437f30aed7ac2?rik=JdClRyfIPNzkog&pid=ImgRaw&r=0', ['Military']));
    }

    // 4. LOGIC XỬ LÝ TAG (Quan trọng)
    // Lấy ra tất cả các tag duy nhất có trong danh sách bài viết
    // Kết quả sẽ là: ['Yoga', 'Cardio', 'Military']
    $uniqueTags = $categoryPosts->pluck('tags')->flatten()->unique()->values();

@endphp
{{-- KẾT THÚC MOCK DATA --}}


<div class="mx-auto px-4 py-8 max-w-[95%] font-open-sans text-gray-800">
    
    {{-- SECTION 1: HERO & SIDE LIST --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12 font-roboto">
        
        {{-- Left: Bài viết nổi bật --}}
        @if(isset($featuredPost))
        <div class="lg:col-span-2 relative group overflow-hidden rounded-lg shadow-sm h-[300px] sm:h-[400px] lg:h-[450px]">
            <a href="{{ url('/blog/' . $featuredPost->slug) }}" class="block w-full h-full">
                <img src="{{ $featuredPost->image_url }}" 
                    alt="{{ $featuredPost->title }}" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                
                <div class="absolute bottom-0 left-0 w-full p-6 bg-black/60 backdrop-blur-[2px] text-white">
                    <div class="flex items-center text-xs sm:text-sm text-gray-300 mb-2">
                        {{-- Tên tác giả --}}
                        <span class="font-medium text-white">{{ $featuredPost->author_name }}</span>
                        
                        {{-- Dấu chấm tròn (.) --}}
                        <span class="mx-3 w-1 h-1 bg-gray-400 rounded-full"></span>
                        
                        {{-- Ngày tháng --}}
                        <span>{{ \Carbon\Carbon::parse($featuredPost->published_at)->format('d/m/Y') }}</span>
                    </div>
                    
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight group-hover:text-blue-200 transition-colors">
                        {{ $featuredPost->title }}
                    </h2>
                </div>
            </a>
        </div>
        @endif

        {{-- Right: Danh sách bên phải --}}
        <div class="lg:col-span-1 flex flex-col justify-between space-y-4 h-full font-roboto">
            @foreach($sidePosts as $post)
            <div class="flex gap-4 group cursor-pointer h-full relative">
                <a href="{{ url('/blog/' . $post->slug) }}" class="absolute inset-0 z-10"></a>
                
                {{-- Ảnh nhỏ --}}
                <div class="w-1/3 h-24 lg:h-auto overflow-hidden rounded-lg flex-shrink-0">
                    <img src="{{ $post->image_url }}" 
                        alt="{{ $post->title }}" 
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                </div>
                
                {{-- Nội dung bên phải --}}
                <div class="w-2/3 flex flex-col justify-center">
                    <div class="flex items-center text-[10px] text-gray-500 mb-1">
                        {{-- Tên tác giả --}}
                        <span class="font-bold text-gray-700">{{ $post->author_name }}</span>
                        
                        {{-- Dấu gạch ngang --}}
                        <span class="mx-2 text-gray-400">—</span>
                        
                        {{-- Ngày tháng --}}
                        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</span>
                    </div>
                    
                    <h3 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- SECTION 2: DYNAMIC TAG LOOPS               --}}
    {{-- Tự động sinh ra Section dựa trên Tag       --}}
    
    @foreach($uniqueTags as $tag)
        @php
            // Lọc ra các bài viết thuộc Tag hiện tại
            $postsInTag = $categoryPosts->filter(function($post) use ($tag) {
                return in_array($tag, $post->tags);
            });

            // Nếu không có bài nào thuộc tag này thì bỏ qua (dù logic unique đã chặn rồi)
            if($postsInTag->isEmpty()) continue;
        @endphp

        <div class="mb-12">
            <div class="flex justify-between items-end border-b-1 border-black pb-3 mb-6">
                <h2 class="text-2xl font-montserrat font-bold text-gray-900 uppercase tracking-wide">{{ $tag }}</h2>
                <a href="{{ url('/blog/tag/' . \Illuminate\Support\Str::slug($tag)) }}" class="text-xs font-medium text-gray-500 hover:text-black flex items-center gap-1 transition-colors">
                    Xem tất cả 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($postsInTag as $post)
                <div class="group cursor-pointer relative flex flex-col h-full">
                    <a href="{{ url('/blog/' . $post->slug) }}" class="absolute inset-0 z-10"></a>
                    
                    {{-- Image --}}
                    <div class="overflow-hidden rounded-lg mb-3 aspect-[4/3] bg-gray-100">
                        <img src="{{ $post->image_url }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    
                    {{-- Meta --}}
                    <div class="flex items-center text-[10px] text-gray-500 mb-2 space-x-2 font-roboto">
                        <span class="font-bold text-gray-700">{{ $post->author_name }}</span>
                        <span class="text-gray-400">—</span>
                        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</span>
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="text-sm font-roboto font-bold text-gray-900 leading-snug group-hover:text-[#1E87DB] line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>

@endsection