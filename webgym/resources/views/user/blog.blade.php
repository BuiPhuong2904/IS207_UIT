@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

<div class="mx-auto px-4 py-8 max-w-[95%] font-open-sans text-gray-800">
    
    {{-- SECTION 1: HERO & SIDE LIST --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12 font-roboto">
        
        {{-- Left: Bài viết nổi bật --}}
        @if(isset($featuredPost) && $featuredPost)
        <div class="lg:col-span-2 relative group overflow-hidden rounded-lg shadow-sm h-[300px] sm:h-[400px] lg:h-[450px]">
            <a href="{{ url('/blog/' . $featuredPost->slug) }}" class="block w-full h-full">
                <img src="{{ $featuredPost->image_url }}" 
                    alt="{{ $featuredPost->title }}" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                
                <div class="absolute bottom-0 left-0 w-full p-6 bg-black/60 backdrop-blur-[2px] text-white">
                    <div class="flex items-center text-xs sm:text-sm text-gray-300 mb-2">
                        <span class="font-medium text-white">{{ $featuredPost->author->full_name ?? 'Admin' }}</span>
                        <span class="mx-3 w-1 h-1 bg-gray-400 rounded-full"></span>
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
                <div class="w-1/3 h-24 lg:h-auto overflow-hidden rounded-lg flex-shrink-0">
                    <img src="{{ $post->image_url }}" 
                        alt="{{ $post->title }}" 
                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="w-2/3 flex flex-col justify-center">
                    <div class="flex items-center text-[12px] text-gray-500 mb-1">
                        <span class="font-bold text-gray-700">{{ $post->author->full_name ?? 'Admin' }}</span>
                        <span class="mx-2 text-gray-400">—</span>
                        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- SECTION 2: DYNAMIC TAG LOOPS --}}
    
    @foreach($uniqueTags as $tag)
        @php
            $postsInTag = $categoryPosts->filter(function($post) use ($tag) {
                return in_array($tag, $post->tags_array); 
            });

            if($postsInTag->isEmpty()) continue;

            $postsInTag = $postsInTag->take(4);

            // Xử lý hiển thị tên Tiếng Việt
            $displayTitle = $tagMapping[$tag] ?? ucfirst(str_replace('-', ' ', $tag));
        @endphp

        <div class="mb-12">
            <div class="flex justify-between items-end border-b-1 border-black pb-3 mb-6">
                {{-- Hiển thị tên biến đã xử lý --}}
                <h2 class="text-2xl font-montserrat font-bold text-[#0D47A1] uppercase tracking-wide">
                    {{ $displayTitle }}
                </h2>
                
                <a href="#" class="text-xs font-medium text-gray-500 hover:text-blue-600 flex items-center gap-1 transition-colors">
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
                    <div class="flex items-center text-[12px] text-gray-500 mb-2 space-x-2 font-roboto">
                        <span class="font-bold text-gray-700">{{ $post->author->full_name ?? 'Admin' }}</span>
                        <span class="text-gray-400">—</span>
                        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</span>
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="text-xl font-roboto font-bold text-gray-900 leading-snug group-hover:text-[#1E87DB] line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>

@endsection