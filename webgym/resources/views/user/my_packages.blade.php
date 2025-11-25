@extends('user.layouts.user_dashboard')

@section('title', 'Gói tập đã mua - GRYND')

<script src="//unpkg.com/alpinejs" defer></script>

@section('content')

<div x-data="{ currentTab: 'all' }">
    <!-- Tiêu đề trang -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black font-montserrat">Gói tập của bạn</h1>
        <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý gói tập</p>
    </div>

    <!-- Bộ lọc gói tập -->
    <div class="mb-6 flex gap-2 font-open-sans">
        {{-- Nút TẤT CẢ --}}
        <button 
            @click="currentTab = 'all'"
            :class="currentTab === 'all' 
                ? 'bg-[#1976D2]/20 text-[#1976D2] font-bold shadow-sm' 
                : 'bg-[#999999]/20 text-gray-600 font-semibold hover:bg-gray-300'"
            class="px-5 py-2 rounded-full text-sm transition-all duration-200 border border-transparent">
            Tất cả
        </button>

        {{-- Nút CÒN HẠN --}}
        <button 
            @click="currentTab = 'active'"
            :class="currentTab === 'active' 
                ? 'bg-[#1976D2]/20 text-[#1976D2] font-bold shadow-sm' 
                : 'bg-[#999999]/20 text-gray-600 font-semibold hover:bg-gray-300'"
            class="px-5 py-2 rounded-full text-sm transition-all duration-200 border border-transparent">
            Còn hạn
        </button>

        {{-- Nút HẾT HẠN --}}
        <button 
            @click="currentTab = 'expired'"
            :class="currentTab === 'expired' 
                ? 'bg-[#1976D2]/20 text-[#1976D2] font-bold shadow-sm' 
                : 'bg-[#999999]/20 text-gray-600 font-semibold hover:bg-gray-300'"
            class="px-5 py-2 rounded-full text-sm transition-all duration-200 border border-transparent">
            Hết hạn
        </button>
    </div>

    <!-- Danh sách gói tập -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 font-open-sans">
        @foreach($packages as $pack)
            @php
                $isExpired = $pack['status'] === 'expired';
                $progressColor = $isExpired ? 'bg-[#F44336]' : 'bg-[#28A745]';
                $daysLeftColor = $isExpired ? 'text-[#F44336]' : 'text-[#28A745]';
                $contentOpacity = $isExpired ? 'opacity-60 grayscale-[50%]' : '';
                $textColor = $isExpired ? 'text-[#333333]/60' : 'text-[#333333]';
            @endphp

            {{-- Logic hiển thị: Nếu tab là 'all' HOẶC trạng thái gói trùng với tab hiện tại thì hiển thị --}}
            <div x-show="currentTab === 'all' || currentTab === '{{ $pack['status'] }}'"
                    x-transition.duration.300ms
                    class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col justify-between h-full hover:shadow-lg transition-shadow duration-300">       
                
                {{-- Nội dung Card --}}
                <div>
                    <h3 class="text-[20px] font-bold text-black font-montserrat mb-4 truncate" title="{{ $pack['name'] }}">
                        {{ $pack['name'] }}
                    </h3>
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-[12px] text-black">Thời hạn</span>
                            @if($isExpired)
                                    <span class="text-[12px] font-bold text-[#F44336]">Đã hết hạn</span>
                            @else
                                    <span class="text-[12px] font-semibold {{ $daysLeftColor }}">còn {{ $pack['days_left'] }} ngày</span>
                            @endif
                        </div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="{{ $progressColor }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $pack['progress'] }}%"></div>
                        </div>
                        
                        <div class="text-right mt-1">
                            <span class="text-[11px] text-[#333333]/60">Hết hạn {{ $pack['expiry_date'] }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-4"></div>

                    <div class="{{ $contentOpacity }}">
                        <p class="font-semibold text-sm {{ $textColor }} mb-3">Quyền lợi:</p>
                        <ul class="space-y-2">
                            @foreach($pack['benefits'] as $benefit)
                            <li class="flex items-start gap-2 text-sm {{ $textColor }}">
                                <svg class="w-4 h-4 mt-0.5 {{ $isExpired ? 'text-gray-400' : 'text-gray-800' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="leading-tight">{{ $benefit }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div x-show="currentTab === 'active' && {{ collect($packages)->where('status', 'active')->count() }} === 0" class="text-center text-gray-500 py-10" style="display: none;">
        Bạn chưa có gói tập nào đang hoạt động.
    </div>
    <div x-show="currentTab === 'expired' && {{ collect($packages)->where('status', 'expired')->count() }} === 0" class="text-center text-gray-500 py-10" style="display: none;">
        Bạn chưa có gói tập nào hết hạn.
    </div>
</div>

@endsection