@extends('user.layouts.user_layout')

@section('title', 'GRYND - Gói tập')

@section('content')

<!-- Background Section -->
<section class="relative bg-black h-[75vh] flex items-center">
  
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/class/background.png') }}"
            alt="GRYND - Background"
            class="h-full w-full object-cover object-top opacity-80">
    </div>

    <div class="relative z-10 max-w-6xl px-20 text-white">
    
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3 md:items-center">
        
            <div class="md:col-span-2">
                <h1 class="mb-4 font-extrabold text-[55px] font-montserrat text-[#42A5F5] whitespace-nowrap">
                    CHINH PHỤC CƠ THỂ
                </h1>

                <p class="font-normal text-[24px] font-open-sans text-white leading-relaxed text-justify">
                    Khám phá các gói luyện tập đa dạng, được thiết kế linh hoạt theo từng mục
                    tiêu cá nhân của bạn, và bắt đầu hành trình lột xác toàn diện ngay hôm nay để
                    chinh phục vóc dáng và phong độ mà bạn mong muốn!
                </p>
            </div>

            <div class="hidden md:block"></div>

        </div>
    </div>
</section>

<!-- Featured Packages Section -->
<section class="bg-[#E3F2FD] py-12 px-10 md:px-20 text-center">
    <h2 class="text-[28px] font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
        LỰA CHỌN GÓI TẬP
    </h2>

    <div class="w-48 h-[3px] mx-auto mb-10 rounded-full"
        style="background: linear-gradient(90deg, #0D47A1, #42A5F5);">
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">

        @foreach($packages as $package)
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 
                        @if($package->is_featured) border-t-4 border-[#FFD700] @endif">

                {{-- Hiển thị tag HOT NẾU là 'featured' --}}
                @if($package->is_featured)
                <span class="absolute top-3 right-3 bg-[#FFD700] text-[#0D47A1] font-semibold text-xs px-3 py-1 rounded-full shadow">
                    🔥 HOT
                </span>
                @endif

                {{-- Div bọc nội dung --}}
                <div class="flex flex-col items-center gap-3">

                    <img src="{{ $package->image_url }}" 
                        alt="{{ $package->package_name }}" class="w-14 h-14 mb-2">

                    <h4 class="text-lg font-semibold text-[#0D47A1]">{{ $package->package_name }}</h4>

                    <p class="text-[#1976D2] font-bold text-xl mb-2">{{ number_format($package->price, 0, ',', '.') }} Đ / gói</p>

                    <ul class="text-[#333333] text-sm space-y-1 mb-4 text-left">
                        @foreach($package->features_list as $feature)
                            <li>✔️ {{ $feature }}</li>
                        @endforeach
                    </ul>

                    @if($package->is_featured)
                        {{-- Nút VÀNG cho gói HOT --}}
                        <button class="font-semibold px-6 py-2 rounded-full text-[#0D47A1]
                                       transition-all duration-300 shadow-md hover:shadow-lg
                                       hover:scale-105 active:scale-95"
                                style="background: linear-gradient(90deg, #FFDD00, #F7B731);">
                            Đăng ký ngay
                        </button>
                    @else
                        {{-- Nút XANH cho gói thường --}}
                        <button class="bg-[#1976D2] text-white font-semibold px-5 py-2 rounded-full hover:bg-[#0D47A1] transition">
                            Đăng ký ngay
                        </button>
                    @endif
                
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection