@extends('user.layouts.user_dashboard')

@section('title', 'Lớp học đã đăng ký - GRYND')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<!-- <script src="//unpkg.com/alpinejs" defer></script> -->

@section('content')

<div x-data="{ currentTab: 'all' }">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black font-montserrat">Lớp học của bạn</h1>
        <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý lịch sử đăng ký lớp học</p>
    </div>

    <div class="mb-6 flex flex-wrap gap-2 font-open-sans">
        <button @click="currentTab = 'all'" :class="currentTab === 'all' ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200'" class="px-5 py-2 rounded-full text-sm transition-all duration-200">Tất cả</button>
        <button @click="currentTab = 'registered'" :class="currentTab === 'registered' ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200'" class="px-5 py-2 rounded-full text-sm transition-all duration-200">Đã đăng ký</button>
        <button @click="currentTab = 'completed'" :class="currentTab === 'completed' ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200'" class="px-5 py-2 rounded-full text-sm transition-all duration-200">Hoàn thành</button>
        <button @click="currentTab = 'cancelled'" :class="currentTab === 'cancelled' ? 'bg-blue-100 text-blue-700 font-bold shadow-sm' : 'bg-gray-100 text-gray-600 font-semibold hover:bg-gray-200'" class="px-5 py-2 rounded-full text-sm transition-all duration-200">Đã hủy</button>
    </div>

    {{-- TRƯỜNG HỢP CHƯA CÓ DỮ LIỆU --}}
    @if($classes->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 text-center">
            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-700 mb-2">Bạn chưa đăng ký lớp học nào</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">Hãy tham gia các lớp học thú vị tại GRYND để rèn luyện sức khỏe ngay hôm nay!</p>
            <a href="{{ route('class') }}" class="px-6 py-2.5 bg-[#0D47A1] hover:bg-[#0D47A1]/90 text-white font-semibold rounded-full transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Đăng ký lớp ngay
            </a>
        </div>
    @else
        {{-- Nếu có dữ liệu, hiển thị lưới lớp học --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 font-open-sans">
            @foreach($classes as $class)
                @php
                    $statusColor = '';
                    switch ($class['status']) {
                        case 'registered': $statusColor = 'text-[#4A90E2] font-bold'; break;
                        case 'completed': $statusColor = 'text-[#28A745] font-bold'; break;
                        case 'cancelled': $statusColor = 'text-[#D32F2F] font-bold'; break;
                    }
                @endphp

                {{-- Card Item --}}
                <div x-show="currentTab === 'all' || currentTab === '{{ $class['status'] }}'"
                    x-transition.duration.300ms
                    class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                    
                    {{-- Tên lớp học --}}
                    <div class="mb-3">
                        <h3 class="text-xl font-bold text-[#0D47A1] font-montserrat truncate" title="{{ $class['name'] }}">
                            {{ $class['name'] }}
                        </h3>
                    </div>

                    {{-- Đường kẻ ngang --}}
                    <div class="border-t border-gray-200 mb-4"></div>

                    {{-- Thông tin chi tiết --}}
                    <div class="pl-2 flex-grow"> 
                        <div class="grid grid-cols-[90px_1fr] gap-y-3 text-sm">
                            
                            <div class="text-[#333333]/80 font-semibold">Thời gian:</div>
                            <div class="text-black">{{ $class['time'] }}</div>

                            <div class="text-[#333333]/80 font-semibold">Ngày:</div>
                            <div class="text-black">{{ $class['date'] }}</div>

                            <div class="text-[#333333]/80 font-semibold">Phòng học:</div>
                            <div class="text-black">{{ $class['room'] }}</div>

                            <div class="text-[#333333]/80 font-semibold">Chi nhánh:</div>
                            <div class="text-black">{{ $class['branch'] }}</div>

                            <div class="text-[#333333]/80 font-semibold">Trạng thái:</div>
                            <div class="{{ $statusColor }}">
                                {{ $class['status_label'] }}
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    
        {{-- Dùng biến counts để kiểm tra --}}
        <div x-show="currentTab !== 'all' && counts[currentTab] === 0" class="text-center text-gray-400 mt-10 italic font-open-sans" style="display: none;">
            Không tìm thấy lớp học nào ở trạng thái này.
        </div>
    @endif
</div>

@endsection