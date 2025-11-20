@extends('user.layouts.user_layout')

@section('title', 'GRYND - Gói tập')

@section('content')

<!-- Background Section -->
<!--<section class="relative bg-black h-[75vh] flex items-center">
  
    <div class="relative w-full h-[300px] md:h-[400px] lg:h-[540px] overflow-hidden">
        
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/package/package.png') }}"
                alt="GRYND - Background"
                class="h-full w-full object-cover object-top opacity-80 transition-opacity duration-500">
        </div>
    </div>

    <div class="relative z-10 max-w-6xl px-20 text-white">
    
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3 md:items-center">

            <div class="hidden md:block"></div>

        </div>
    </div>
</section>-->
<div class="relative w-full 
            aspect-[4/3] 
            sm:aspect-video 
            md:aspect-[21/9] 
            lg:aspect-[1920/540] 
            overflow-hidden">
            
    <div class="absolute inset-0 bg-black opacity-20 z-10"></div>
    
    <img
        src="{{ asset('images/package/background_1.png') }}"
        alt="GRYND - Background"
        class="absolute inset-0 h-full w-full object-cover object-center lg:object-top opacity-80">
        
</div>

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