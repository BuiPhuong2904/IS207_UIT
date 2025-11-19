@extends('user.layouts.user_layout')

@section('title', 'GRYND - Lớp học')

@section('content')

<!-- Background Section -->
<div class="relative w-full 
            aspect-[4/3] 
            sm:aspect-video 
            md:aspect-[21/9] 
            lg:aspect-[1920/540] 
            overflow-hidden">
            
    <div class="absolute inset-0 bg-black opacity-10 z-10"></div>
    
    <img
        src="{{ asset('images/class/background_1.png') }}"
        alt="GRYND - Background"
        class="absolute inset-0 h-full w-full object-cover object-center lg:object-top opacity-90">
</div>

<!-- Classes Section -->
<section class="bg-white pt-10 pb-16 sm:pb-24">
    <h2 class="text-[28px] text-center font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
        DANH SÁCH LỚP HỌC
    </h2>

    <div class="w-48 h-[3px] mx-auto mb-10 rounded-full"
        style="background: linear-gradient(90deg, #0D47A1, #42A5F5);">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($classes as $class)
            <div class="bg-white rounded-[20px] shadow-md overflow-hidden flex flex-col border-2 border-[#1976D2]">
                
                <div class="p-3 w-full rounded-[20px]"> 
                    {{-- Ảnh động từ CSDL --}}
                    <img class="w-full h-56 object-cover rounded-[20px]" 
                        src="{{ $class->image_url }}" 
                        alt="{{ $class->class_name }}">
                </div>
                
                <div class="pt-4 pb-6 px-6 flex flex-col flex-grow">
                
                    {{-- Tên lớp học --}}
                    <h3 class="text-2xl font-bold text-[#0D47A1] font-montserrat">
                        {{ $class->class_name }}
                    </h3>
                
                    <div class="mt-4 space-y-2 text-sm text-[#333333] font-open-sans">
                        <div class="flex items-center">
                            {{-- Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 mr-2 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                            </svg>
                            {{-- Loại lớp --}}
                            <span>Loại: <strong>{{ $class->type }}</strong></span>
                        </div>
                        <div class="flex items-center">
                            {{-- Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 mr-2 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            {{-- Sĩ số --}}
                            <span>Sĩ số: <strong>{{ $class->max_capacity }}</strong></span>
                        </div>
                    </div>
                
                    {{-- Mô tả --}}
                    <p class="mt-4 text-[#333333] text-sm leading-relaxed flex-grow font-open-sans">
                        {{ $class->description }}
                    </p>
                
                    <div class="mt-6">
                        <a href="#" class="block w-full text-center text-white px-6 py-3 rounded-[20px] transition-colors font-open-sans font-bold bg-[#1976D2] hover:bg-blue-800">
                        Đặt lịch ngay
                        </a>
                    </div>
                </div>
            </div>
            @endforeach        
        </div> 
    </div>
</section>
@endsection