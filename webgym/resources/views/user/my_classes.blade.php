@extends('user.layouts.user_dashboard')

@section('title', 'Lớp học đã đăng ký - GRYND')

<script src="//unpkg.com/alpinejs" defer></script>

@section('content')

{{-- 1. DỮ LIỆU GIẢ (Mô phỏng từ ClassScheduleSeeder) --}}
@php
    $classes = [
        [
            'name' => 'Lớp HIIT Cường độ cao',
            'time' => '06:00 - 07:00',
            'date' => '24/11/2025',
            'room' => 'Studio 1',
            'branch' => 'CN Phước Ninh',
            'status' => 'completed',
            'status_label' => 'Hoàn thành'
        ],
        [
            'name' => 'Lớp Pilates',
            'time' => '08:00 - 09:00',
            'date' => '24/11/2025',
            'room' => 'Studio 2',
            'branch' => 'CN Linh Xuân',
            'status' => 'completed',
            'status_label' => 'Hoàn thành'
        ],
        [
            'name' => 'Lớp Zumba Dance',
            'time' => '18:00 - 19:00',
            'date' => '25/11/2025',
            'room' => 'Studio 1',
            'branch' => 'CN Lý Thường Kiệt',
            'status' => 'registered',
            'status_label' => 'Đã đăng ký'
        ],
        [
            'name' => 'Lớp Boxing Kỹ Thuật',
            'time' => '19:00 - 20:00',
            'date' => '25/11/2025',
            'room' => 'Boxing Ring',
            'branch' => 'CN Hoàng Diệu',
            'status' => 'registered',
            'status_label' => 'Đã đăng ký'
        ],
        [
            'name' => 'Lớp Yoga Trị Liệu',
            'time' => '07:00 - 08:00',
            'date' => '26/11/2025',
            'room' => 'Studio 2',
            'branch' => 'CN Phước Ninh',
            'status' => 'registered',
            'status_label' => 'Đã đăng ký'
        ],
        [
            'name' => 'Lớp Yoga Nâng Cao',
            'time' => '10:00 - 11:00',
            'date' => '28/11/2025',
            'room' => 'Studio 2',
            'branch' => 'CN Lý Thường Kiệt',
            'status' => 'cancelled',
            'status_label' => 'Đã hủy'
        ],
        [
            'name' => 'Lớp Gym BodyPump',
            'time' => '17:00 - 18:00',
            'date' => '29/11/2025',
            'room' => 'Gym Floor',
            'branch' => 'CN Linh Xuân',
            'status' => 'cancelled',
            'status_label' => 'Đã hủy'
        ]
    ];

    // TÍNH TOÁN SỐ LƯỢNG (Để xử lý thông báo "Không tìm thấy")
    $counts = [
        'registered' => collect($classes)->where('status', 'registered')->count(),
        'completed'  => collect($classes)->where('status', 'completed')->count(),
        'cancelled'  => collect($classes)->where('status', 'cancelled')->count(),
    ];
@endphp

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
                    <h3 class="text-xl font-bold text-[#000000] font-montserrat truncate" title="{{ $class['name'] }}">
                        {{ $class['name'] }}
                    </h3>
                </div>

                {{-- Đường kẻ ngang --}}
                <div class="border-t border-gray-200 mb-4"></div>

                {{-- Thông tin chi tiết --}}
                <div class="pl-2 flex-grow"> 
                    <div class="grid grid-cols-[90px_1fr] gap-y-3 text-sm">
                        
                        <div class="text-[#333333]/80 font-medium">Thời gian:</div>
                        <div class="text-black font-semibold">{{ $class['time'] }}</div>

                        <div class="text-[#333333]/80 font-medium">Ngày:</div>
                        <div class="text-black font-semibold">{{ $class['date'] }}</div>

                        <div class="text-[#333333]/80 font-medium">Phòng học:</div>
                        <div class="text-black font-semibold">{{ $class['room'] }}</div>

                        <div class="text-[#333333]/80 font-medium">Chi nhánh:</div>
                        <div class="text-black font-semibold">{{ $class['branch'] }}</div>

                         <div class="text-[#333333]/80 font-medium">Trạng thái:</div>
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
</div>

@endsection