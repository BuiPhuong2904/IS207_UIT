@extends('user.layouts.user_layout')

@section('title', 'GRYND - Lớp học')

@section('content')

<!-- Background Section -->
<section class="bg-[#F5F7FA] grid grid-cols-1 md:grid-cols-12 items-start">
  
    <div class="md:col-span-7 pt-8 sm:pt-16 pb-16 sm:pb-24 px-4 sm:px-6 lg:px-8 text-center md:text-left">
        <h2 class="font-extrabold tracking-tight font-montserrat text-[60px] bg-gradient-to-b from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            <span class="block">GIỚI THIỆU</span>
            <span class="block">CÁC KHÓA HỌC</span>
        </h2>
        
        <p class="mt-6 text-lg text-black leading-relaxed text-justify font-open-sans">
            Grynd mang đến hệ thống các khóa học đa dạng như Gym, Yoga, Zumba, Cardio 
            cùng nhiều chương trình rèn luyện chuyên sâu khác, phù hợp với mọi độ tuổi, 
            thể trạng và mục tiêu tập luyện. Tại đây, mỗi khóa học không chỉ dừng lại ở những buổi tập đơn thuần 
            mà còn là một hành trình trải nghiệm toàn diện, nơi bạn được lắng nghe cơ thể, 
            chinh phục giới hạn và nuôi dưỡng lối sống khỏe mạnh, tích cực.
        </p>
    </div>
    
    <div class="md:col-span-5 h-full"> 
        <img src="{{ asset('images/package/background.png') }}"
            alt="Nữ vận động viên mỉm cười cầm chai nước" 
            class="w-full h-full object-cover object-top" 
            style="max-height: 500px;" >
    </div>  
</section>

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